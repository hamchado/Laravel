<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Auth Controller - متحكم المصادقة
 * 
 * يحتوي على جميع عمليات المصادقة والأمان:
 * - تسجيل الدخول
 * - تسجيل الخروج
 * - التحقق بخطوتين (OTP)
 * - إعادة تعيين كلمة المرور
 * - التحقق من الجلسة
 */
class AuthController extends Controller
{
    /**
     * الحد الأقصى لمحاولات تسجيل الدخول
     */
    private const MAX_LOGIN_ATTEMPTS = 5;
    
    /**
     * مدة الحظر بعد تجاوز المحاولات (بالدقائق)
     */
    private const LOCKOUT_DURATION = 15;

    /**
     * مدة صلاحية OTP (بالدقائق)
     */
    private const OTP_EXPIRY = 10;

    /**
     * تسجيل الدخول
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // التحقق من البيانات المدخلة
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني غير صالح.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صالحة.',
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->input('email');
        $ipAddress = $request->ip();

        // التحقق من عدد المحاولات
        if ($this->isRateLimited($email, $ipAddress)) {
            $this->logAudit('login_rate_limited', $request, [
                'email' => $email,
                'ip' => $ipAddress
            ]);

            return response()->json([
                'success' => false,
                'message' => 'عدد المحاولات تجاوز الحد المسموح. يرجى المحاولة بعد ' . self::LOCKOUT_DURATION . ' دقيقة.',
                'code' => 'RATE_LIMITED',
                'retry_after' => self::LOCKOUT_DURATION * 60
            ], 429);
        }

        // البحث عن المستخدم
        $user = User::with('role')->where('email', $email)->first();

        if (!$user) {
            $this->incrementLoginAttempts($email, $ipAddress);
            
            return response()->json([
                'success' => false,
                'message' => 'بيانات تسجيل الدخول غير صحيحة.',
                'code' => 'INVALID_CREDENTIALS'
            ], 401);
        }

        // التحقق من كلمة المرور
        if (!Hash::check($request->input('password'), $user->password)) {
            $this->incrementLoginAttempts($email, $ipAddress);
            
            $this->logAudit('login_failed', $request, [
                'user_id' => $user->id,
                'reason' => 'invalid_password'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'بيانات تسجيل الدخول غير صحيحة.',
                'code' => 'INVALID_CREDENTIALS'
            ], 401);
        }

        // التحقق من أن الحساب نشط
        if (!$user->is_active) {
            $this->logAudit('login_failed', $request, [
                'user_id' => $user->id,
                'reason' => 'account_inactive'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'الحساب معطل. يرجى التواصل مع الإدارة.',
                'code' => 'ACCOUNT_DISABLED'
            ], 403);
        }

        // إنشاء OTP للتحقق بخطوتين
        $otpCode = $this->generateOtp($user);

        // تسجيل محاولة الدخول الناجحة
        $this->logAudit('login_otp_sent', $request, [
            'user_id' => $user->id,
            'otp_code' => $otpCode->code
        ]);

        // إعادة تعيين عدد المحاولات
        $this->clearLoginAttempts($email, $ipAddress);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال رمز التحقق. يرجى إدخال الرمز.',
            'data' => [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'role' => $user->role->name,
                'requires_otp' => true,
                'otp_expiry' => self::OTP_EXPIRY * 60, // بالثواني
            ]
        ]);
    }

    /**
     * التحقق من OTP وإكمال تسجيل الدخول
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'otp_code' => 'required|string|size:8',
        ], [
            'user_id.required' => 'معرف المستخدم مطلوب.',
            'user_id.exists' => 'المستخدم غير موجود.',
            'otp_code.required' => 'رمز التحقق مطلوب.',
            'otp_code.size' => 'رمز التحقق يجب أن يكون 8 أرقام.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صالحة.',
                'errors' => $validator->errors()
            ], 422);
        }

        $userId = $request->input('user_id');
        $otpCode = $request->input('otp_code');
        $ipAddress = $request->ip();

        // البحث عن رمز OTP
        $otp = OtpCode::where('user_id', $userId)
            ->where('code', $otpCode)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            // زيادة عدد المحاولات
            $otpRecord = OtpCode::where('user_id', $userId)
                ->where('code', $otpCode)
                ->first();

            if ($otpRecord) {
                $otpRecord->increment('attempts');
                
                // إذا تجاوز عدد المحاولات 3، نلغي الرمز
                if ($otpRecord->attempts >= 3) {
                    $otpRecord->update(['used' => true]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'رمز التحقق غير صحيح أو منتهي الصلاحية.',
                'code' => 'INVALID_OTP'
            ], 401);
        }

        // تحديث حالة OTP
        $otp->update([
            'used' => true,
            'used_at' => now(),
            'ip_address' => $ipAddress,
        ]);

        // الحصول على المستخدم
        $user = User::with('role')->find($userId);

        // حذف الجلسات القديمة للمستخدم (منع تعدد تسجيل الدخول)
        DB::table('sessions')->where('user_id', $userId)->delete();

        // إنشاء جلسة جديدة
        Auth::login($user);
        $request->session()->regenerate();

        // حفظ الجلسة في قاعدة البيانات
        DB::table('sessions')->insert([
            'id' => session()->getId(),
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'user_agent' => $request->userAgent(),
            'payload' => '',
            'last_activity' => time(),
        ]);

        // تسجيل الدخول الناجح
        $this->logAudit('login_successful', $request, [
            'user_id' => $user->id,
            'session_id' => session()->getId()
        ]);

        // إنشاء توكن API (اختياري)
        // $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الدخول بنجاح.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'student_id' => $user->student_id,
                    'phone' => $user->phone,
                    'role' => [
                        'name' => $user->role->name,
                        'label' => $user->role->label,
                    ],
                ],
                'session_id' => session()->getId(),
                // 'token' => $token,
            ]
        ]);
    }

    /**
     * تسجيل الخروج
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $userId = Auth::id();

        // تسجيل الخروج
        $this->logAudit('logout', $request, [
            'user_id' => $userId
        ]);

        // حذف الجلسة من قاعدة البيانات
        if ($userId) {
            DB::table('sessions')->where('user_id', $userId)->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الخروج بنجاح.'
        ]);
    }

    /**
     * إعادة تعيين كلمة المرور - طلب OTP
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني غير صالح.',
            'email.exists' => 'البريد الإلكتروني غير مسجل.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صالحة.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->input('email'))->first();

        // إنشاء OTP جديد
        $otpCode = $this->generateOtp($user, 'password_reset');

        $this->logAudit('password_reset_requested', $request, [
            'user_id' => $user->id
        ]);

        // TODO: إرسال OTP عبر SMS أو البريد الإلكتروني

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال رمز التحقق لإعادة تعيين كلمة المرور.',
            'data' => [
                'user_id' => $user->id,
                'otp_expiry' => self::OTP_EXPIRY * 60,
            ]
        ]);
    }

    /**
     * إعادة تعيين كلمة المرور - التحقق من OTP وتعيين كلمة المرور الجديدة
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'otp_code' => 'required|string|size:8',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'user_id.required' => 'معرف المستخدم مطلوب.',
            'otp_code.required' => 'رمز التحقق مطلوب.',
            'password.required' => 'كلمة المرور الجديدة مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صالحة.',
                'errors' => $validator->errors()
            ], 422);
        }

        $userId = $request->input('user_id');
        $otpCode = $request->input('otp_code');

        // التحقق من OTP
        $otp = OtpCode::where('user_id', $userId)
            ->where('code', $otpCode)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return response()->json([
                'success' => false,
                'message' => 'رمز التحقق غير صحيح أو منتهي الصلاحية.',
                'code' => 'INVALID_OTP'
            ], 401);
        }

        // تحديث كلمة المرور
        $user = User::find($userId);
        $oldPasswordHash = $user->password;
        
        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        // تحديث حالة OTP
        $otp->update([
            'used' => true,
            'used_at' => now(),
        ]);

        // تسجيل التغيير
        $this->logAudit('password_reset_successful', $request, [
            'user_id' => $user->id,
            'old_data' => ['password' => '***'],
            'new_data' => ['password' => '***']
        ]);

        // حذف جميع الجلسات القديمة
        DB::table('sessions')->where('user_id', $userId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم إعادة تعيين كلمة المرور بنجاح. يرجى تسجيل الدخول مرة أخرى.'
        ]);
    }

    /**
     * تغيير كلمة المرور (للمستخدم المسجل دخوله)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'كلمة المرور الحالية مطلوبة.',
            'password.required' => 'كلمة المرور الجديدة مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صالحة.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        // التحقق من كلمة المرور الحالية
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'كلمة المرور الحالية غير صحيحة.',
                'code' => 'INVALID_CURRENT_PASSWORD'
            ], 401);
        }

        // تحديث كلمة المرور
        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        $this->logAudit('password_changed', $request, [
            'user_id' => $user->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تغيير كلمة المرور بنجاح.'
        ]);
    }

    /**
     * الحصول على معلومات المستخدم الحالي
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = Auth::user()->load('role');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'student_id' => $user->student_id,
                'phone' => $user->phone,
                'is_active' => $user->is_active,
                'role' => [
                    'name' => $user->role->name,
                    'label' => $user->role->label,
                ],
                'permissions' => $this->getUserPermissions($user->role->name),
            ]
        ]);
    }

    /**
     * التحقق من حالة الجلسة
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSession(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'authenticated' => false,
                'message' => 'الجلسة غير صالحة.'
            ], 401);
        }

        $user = Auth::user()->load('role');

        return response()->json([
            'success' => true,
            'authenticated' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role->name,
                ],
                'session_expires_at' => now()->addMinutes(config('session.lifetime', 60))->toIso8601String(),
            ]
        ]);
    }

    /**
     * إنشاء OTP جديد
     * 
     * @param User $user
     * @param string $type
     * @return OtpCode
     */
    private function generateOtp(User $user, string $type = 'login'): OtpCode
    {
        // إلغاء جميع رموز OTP القديمة
        OtpCode::where('user_id', $user->id)
            ->where('used', false)
            ->update(['used' => true]);

        // إنشاء رمز OTP عشوائي (8 أرقام)
        $code = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);

        return OtpCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(self::OTP_EXPIRY),
            'used' => false,
            'attempts' => 0,
            'phone_number' => $user->phone,
            'delivery_method' => 'manual', // يمكن تغييره إلى 'sms' لاحقاً
        ]);
    }

    /**
     * التحقق من حالة الحد من المحاولات
     * 
     * @param string $email
     * @param string $ipAddress
     * @return bool
     */
    private function isRateLimited(string $email, string $ipAddress): bool
    {
        $key = 'login_attempts:' . md5($email . $ipAddress);
        $attempts = Cache::get($key, 0);

        return $attempts >= self::MAX_LOGIN_ATTEMPTS;
    }

    /**
     * زيادة عدد المحاولات
     * 
     * @param string $email
     * @param string $ipAddress
     */
    private function incrementLoginAttempts(string $email, string $ipAddress): void
    {
        $key = 'login_attempts:' . md5($email . $ipAddress);
        $attempts = Cache::get($key, 0);
        Cache::put($key, $attempts + 1, now()->addMinutes(self::LOCKOUT_DURATION));
    }

    /**
     * إعادة تعيين عدد المحاولات
     * 
     * @param string $email
     * @param string $ipAddress
     */
    private function clearLoginAttempts(string $email, string $ipAddress): void
    {
        $key = 'login_attempts:' . md5($email . $ipAddress);
        Cache::forget($key);
    }

    /**
     * الحصول على صلاحيات المستخدم
     * 
     * @param string $roleName
     * @return array
     */
    private function getUserPermissions(string $roleName): array
    {
        $permissions = [
            'student' => [
                'patients.view_own',
                'patients.create',
                'patients.edit_own',
                'reservations.create',
                'reservations.cancel_own',
                'cases.create',
                'cases.view_own',
                'grants.create',
                'grants.accept',
                'profile.view',
                'profile.edit',
            ],
            'admin' => [
                'users.view',
                'users.create',
                'users.edit',
                'patients.view_all',
                'reservations.view_all',
                'cases.view_all',
                'courses.manage',
                'reports.view',
                'audit_log.view',
            ],
            'supervisor' => [
                'cases.evaluate',
                'cases.view_all',
                'patients.view_all',
                'evaluations.create',
                'reports.view',
            ],
            'ayham' => [
                '*', // جميع الصلاحيات
            ],
        ];

        return $permissions[$roleName] ?? ['profile.view'];
    }

    /**
     * تسجيل عملية المراقبة
     * 
     * @param string $action
     * @param Request $request
     * @param array $extraData
     */
    private function logAudit(string $action, Request $request, array $extraData = []): void
    {
        try {
            AuditLog::create([
                'user_id' => $extraData['user_id'] ?? Auth::id(),
                'action' => $action,
                'model' => 'Auth',
                'model_id' => null,
                'old_data' => $extraData['old_data'] ?? null,
                'new_data' => json_encode(array_merge([
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'ip' => $request->ip(),
                ], $extraData)),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log audit: ' . $e->getMessage());
        }
    }
}
