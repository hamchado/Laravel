<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Role Middleware - التحقق من صلاحيات المستخدم
 * 
 * هذا الميدل وير يتحقق من أن المستخدم لديه الدور المطلوب للوصول إلى المورد
 * This middleware checks if the user has the required role to access the resource
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  الأدوار المسموح بها
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // التحقق من تسجيل دخول المستخدم
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح. يرجى تسجيل الدخول أولاً.',
                'code' => 'UNAUTHENTICATED'
            ], 401);
        }

        $user = Auth::user();
        
        // تحميل علاقة الدور
        $user->load('role');
        
        // التحقق من أن المستخدم نشط
        if (!$user->is_active) {
            // تسجيل محاولة وصول من حساب معطل
            $this->logAudit('inactive_account_access_attempt', $request);
            
            return response()->json([
                'success' => false,
                'message' => 'الحساب معطل. يرجى التواصل مع الإدارة.',
                'code' => 'ACCOUNT_DISABLED'
            ], 403);
        }

        // التحقق من الأدوار المطلوبة
        if (empty($roles)) {
            // إذا لم يتم تحديد أدوار، فأي مستخدم مسجل دخوله يمكنه الوصول
            return $next($request);
        }

        // التحقق من أن المستخدم لديه أحد الأدوار المطلوبة
        if (!in_array($user->role->name, $roles)) {
            // تسجيل محاولة وصول غير مصرح بها
            $this->logAudit('unauthorized_access_attempt', $request, [
                'required_roles' => $roles,
                'user_role' => $user->role->name
            ]);

            return response()->json([
                'success' => false,
                'message' => 'ليس لديك الصلاحية للوصول إلى هذا المورد.',
                'code' => 'FORBIDDEN',
                'required_permissions' => $roles,
                'your_role' => $user->role->label
            ], 403);
        }

        // تسجيل الوصول الناجح للمراقبة (اختياري - يمكن تعطيله في الإنتاج)
        // $this->logAudit('authorized_access', $request);

        return $next($request);
    }

    /**
     * تسجيل عملية المراقبة
     */
    private function logAudit(string $action, Request $request, array $extraData = []): void
    {
        try {
            \App\Models\AuditLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model' => 'Middleware',
                'model_id' => null,
                'old_data' => null,
                'new_data' => json_encode(array_merge([
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'ip' => $request->ip(),
                ], $extraData)),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Exception $e) {
            // تجاهل أخطاء التسجيل - لا تمنع المستخدم من الوصول
            \Log::error('Failed to log audit: ' . $e->getMessage());
        }
    }
}
