<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * OTP Verification Middleware - التحقق من رمز التحقق
 * 
 * هذا الميدل وير يتحقق من أن المستخدم قد أكمل التحقق بخطوتين (2FA)
 * This middleware verifies that the user has completed two-factor authentication
 */
class OtpVerificationMiddleware
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
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح. يرجى تسجيل الدخول أولاً.',
                'code' => 'UNAUTHENTICATED'
            ], 401);
        }

        $user = Auth::user();
        
        // التحقق من اكتمال التحقق بخطوتين
        $otpVerified = Cache::get('otp_verified_' . $user->id, false);
        
        // إذا لم يتم التحقق من OTP، نرفض الوصول
        if (!$otpVerified) {
            return response()->json([
                'success' => false,
                'message' => 'يرجى إكمال التحقق بخطوتين أولاً.',
                'code' => 'OTP_REQUIRED',
                'requires_otp' => true
            ], 403);
        }

        return $next($request);
    }
}
