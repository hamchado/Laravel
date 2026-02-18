<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

/**
 * Single Session Middleware - منع تعدد تسجيل الدخول
 * 
 * هذا الميدل وير يضمن أن المستخدم يمكنه تسجيل الدخول من جهاز واحد فقط في نفس الوقت
 * This middleware ensures users can only be logged in from one device at a time
 */
class SingleSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من تسجيل دخول المستخدم
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        $currentSessionId = Session::getId();
        
        // التحقق من صلاحية الجلسة في قاعدة البيانات
        $sessionValid = $this->validateSession($user->id, $currentSessionId);
        
        if (!$sessionValid) {
            // تسجيل خروج المستخدم
            Auth::logout();
            Session::flush();
            
            // تسجيل الحدث
            $this->logAudit('session_invalidated', $request, [
                'reason' => 'new_login_detected'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'تم تسجيل الخروج. تم تسجيل الدخول من جهاز آخر.',
                'code' => 'SESSION_INVALIDATED'
            ], 401);
        }

        // تحديث وقت النشاط الأخير
        $this->updateLastActivity($currentSessionId);

        return $next($request);
    }

    /**
     * التحقق من صلاحية الجلسة
     */
    private function validateSession(int $userId, string $sessionId): bool
    {
        try {
            // البحث عن جلسات المستخدم
            $userSessions = DB::table('sessions')
                ->where('user_id', $userId)
                ->get();

            // إذا لم تكن هناك جلسات، فالجلسة الحالية غير صالحة
            if ($userSessions->isEmpty()) {
                return false;
            }

            // التحقق من وجود الجلسة الحالية
            $currentSession = $userSessions->firstWhere('id', $sessionId);
            
            if (!$currentSession) {
                // الجلسة الحالية غير موجودة في قاعدة البيانات
                return false;
            }

            // التحقق من عدم انتهاء صلاحية الجلسة (60 دقيقة)
            $lastActivity = $currentSession->last_activity;
            $sessionLifetime = config('session.lifetime', 60) * 60; // بالثواني
            
            if (time() - $lastActivity > $sessionLifetime) {
                // الجلسة منتهية الصلاحية
                DB::table('sessions')->where('id', $sessionId)->delete();
                return false;
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Session validation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * تحديث وقت النشاط الأخير
     */
    private function updateLastActivity(string $sessionId): void
    {
        try {
            DB::table('sessions')
                ->where('id', $sessionId)
                ->update(['last_activity' => time()]);
        } catch (\Exception $e) {
            \Log::error('Failed to update session activity: ' . $e->getMessage());
        }
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
                'model' => 'Session',
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
            \Log::error('Failed to log audit: ' . $e->getMessage());
        }
    }
}
