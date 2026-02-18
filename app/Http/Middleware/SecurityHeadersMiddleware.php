<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Security Headers Middleware - رؤوس الأمان
 * 
 * هذا الميدل وير يضيف رؤوس الأمان اللازمة لحماية التطبيق
 * This middleware adds necessary security headers to protect the application
 */
class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // منع التصيد بالإطارات (Clickjacking)
        $response->headers->set('X-Frame-Options', 'DENY');
        
        // حماية XSS
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // منع sniffing للمحتوى
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // سياسة الأمان للمحتوى
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data: blob:; font-src 'self'; connect-src 'self';");
        
        // سياسة المراجع
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // HSTS (HTTPS Strict Transport Security)
        if (config('app.env') === 'production') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
        
        // سياسة الأذونات
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // إخفاء معلومات الخادم
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
