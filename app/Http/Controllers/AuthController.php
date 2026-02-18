<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect(Auth::user()->getRedirectRoute());
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $key = 'login:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "تم تجاوز عدد المحاولات المسموحة. حاول بعد {$seconds} ثانية.",
            ], 429);
        }

        $user = User::where('student_id', $request->student_id)
            ->where('is_active', true)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            RateLimiter::hit($key, 60 * 15);
            return response()->json([
                'success' => false,
                'message' => 'الرقم الجامعي أو كلمة المرور غير صحيحة',
            ], 401);
        }

        // Single device: delete all previous sessions for this user
        DB::table('sessions')->where('user_id', $user->id)->delete();

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        RateLimiter::clear($key);

        AuditLog::log('login', 'User', $user->id);

        return response()->json([
            'success' => true,
            'redirect' => $user->getRedirectRoute(),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'student_id' => $user->student_id,
                'role' => $user->role->name,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        AuditLog::log('logout', 'User', Auth::id());

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function requestOtp(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
        ]);

        $user = User::where('student_id', $request->student_id)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'الرقم الجامعي غير مسجل في النظام',
            ], 404);
        }

        $otp = OtpCode::generate($user->id);

        // In production, send via email. For now, log it.
        \Log::info("OTP for user {$user->student_id}: {$otp->code}");

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال رمز التحقق. تواصل مع المشرف للحصول على الرمز.',
            'phone' => $user->phone,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
            'code' => 'required|string|size:8',
        ]);

        $user = User::where('student_id', $request->student_id)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'المستخدم غير موجود'], 404);
        }

        $otp = OtpCode::where('user_id', $user->id)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otp) {
            return response()->json(['success' => false, 'message' => 'انتهت صلاحية الرمز'], 400);
        }

        $otp->increment('attempts');

        if ($otp->attempts >= 5) {
            $otp->update(['used' => true]);
            return response()->json(['success' => false, 'message' => 'تم تجاوز عدد المحاولات المسموحة'], 429);
        }

        if ($otp->code !== $request->code) {
            return response()->json(['success' => false, 'message' => 'رمز التحقق غير صحيح'], 400);
        }

        $otp->update(['used' => true, 'used_at' => now()]);

        // Generate a temporary token for password reset
        $token = bin2hex(random_bytes(32));
        cache()->put("password_reset:{$user->id}", $token, 300); // 5 minutes

        return response()->json([
            'success' => true,
            'message' => 'تم التحقق بنجاح',
            'reset_token' => $token,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
            'reset_token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('student_id', $request->student_id)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'المستخدم غير موجود'], 404);
        }

        $cachedToken = cache()->get("password_reset:{$user->id}");
        if (!$cachedToken || $cachedToken !== $request->reset_token) {
            return response()->json(['success' => false, 'message' => 'رمز إعادة التعيين غير صالح'], 400);
        }

        $user->update(['password' => $request->password]);
        cache()->forget("password_reset:{$user->id}");

        AuditLog::log('password_reset', 'User', $user->id);

        return response()->json([
            'success' => true,
            'message' => 'تم تغيير كلمة المرور بنجاح',
        ]);
    }
}
