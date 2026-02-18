<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CaseController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\GrantController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\StatsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - مسارات API
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// =============================================================================
// Public Routes - المسارات العامة
// =============================================================================

Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'message' => 'Multaqa Dental Platform API is running!',
        'version' => '1.0.0',
        'timestamp' => now()->toIso8601String(),
    ]);
});

// =============================================================================
// Authentication Routes - مسارات المصادقة
// =============================================================================

Route::prefix('auth')->group(function () {
    // تسجيل الدخول
    Route::post('/login', [AuthController::class, 'login']);
    
    // التحقق من OTP
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    
    // طلب إعادة تعيين كلمة المرور
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    
    // إعادة تعيين كلمة المرور
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// =============================================================================
// Protected Routes - المسارات المحمية
// =============================================================================

Route::middleware(['auth', 'single.session'])->group(function () {
    
    // -------------------------------------------------------------------------
    // Auth Routes - مسارات المصادقة (للمستخدمين المسجلين)
    // -------------------------------------------------------------------------
    Route::prefix('auth')->group(function () {
        // تسجيل الخروج
        Route::post('/logout', [AuthController::class, 'logout']);
        
        // معلومات المستخدم الحالي
        Route::get('/me', [AuthController::class, 'me']);
        
        // التحقق من حالة الجلسة
        Route::get('/check-session', [AuthController::class, 'checkSession']);
        
        // تغيير كلمة المرور
        Route::put('/change-password', [AuthController::class, 'changePassword']);
    });
    
    // -------------------------------------------------------------------------
    // Profile Routes - مسارات الملف الشخصي
    // -------------------------------------------------------------------------
    Route::prefix('profile')->group(function () {
        Route::get('/', [AuthController::class, 'me']);
        Route::put('/password', [AuthController::class, 'changePassword']);
        Route::put('/phone', [AuthController::class, 'updatePhone']);
    });
    
    // -------------------------------------------------------------------------
    // Patient Routes - مسارات المرضى (للطلاب والمشرفين)
    // -------------------------------------------------------------------------
    Route::prefix('patients')->group(function () {
        // قائمة المرضى
        Route::get('/', [PatientController::class, 'index']);
        
        // إنشاء مريض جديد
        Route::post('/', [PatientController::class, 'store']);
        
        // تفاصيل المريض
        Route::get('/{id}', [PatientController::class, 'show']);
        
        // تحديث المريض
        Route::put('/{id}', [PatientController::class, 'update']);
        
        // حذف المريض
        Route::delete('/{id}', [PatientController::class, 'destroy']);
        
        // صور البانوراما
        Route::get('/{id}/panorama', [PatientController::class, 'panoramaImages']);
        Route::post('/{id}/panorama', [PatientController::class, 'uploadPanorama']);
        
        // أسنان المريض
        Route::get('/{id}/teeth', [PatientController::class, 'teeth']);
        Route::put('/{id}/teeth', [PatientController::class, 'updateTeeth']);
        
        // الحالة الصحية
        Route::get('/{id}/health', [PatientController::class, 'health']);
        Route::put('/{id}/health', [PatientController::class, 'updateHealth']);
        
        // الحالة اللثوية
        Route::get('/{id}/perio', [PatientController::class, 'perio']);
        Route::put('/{id}/perio', [PatientController::class, 'updatePerio']);
    });
    
    // -------------------------------------------------------------------------
    // Reservation Routes - مسارات الحجوزات
    // -------------------------------------------------------------------------
    Route::prefix('reservations')->group(function () {
        // قائمة الحجوزات
        Route::get('/', [ReservationController::class, 'index']);
        
        // إنشاء حجز
        Route::post('/', [ReservationController::class, 'store']);
        
        // تأكيد الحجز
        Route::put('/{id}/confirm', [ReservationController::class, 'confirm']);
        
        // إلغاء الحجز
        Route::put('/{id}/cancel', [ReservationController::class, 'cancel']);
        
        // تفاصيل الحجز
        Route::get('/{id}', [ReservationController::class, 'show']);
    });
    
    // -------------------------------------------------------------------------
    // Case Routes - مسارات الحالات السريرية
    // -------------------------------------------------------------------------
    Route::prefix('cases')->group(function () {
        // قائمة الحالات
        Route::get('/', [CaseController::class, 'index']);
        
        // إنشاء حالة
        Route::post('/', [CaseController::class, 'store']);
        
        // حالة الجلسة (للتحقق من الحد الأقصى)
        Route::get('/session-status', [CaseController::class, 'sessionStatus']);
        
        // تفاصيل الحالة
        Route::get('/{id}', [CaseController::class, 'show']);
        
        // QR Code
        Route::get('/{id}/qr', [CaseController::class, 'qrCode']);
        
        // رفع صورة
        Route::post('/upload', [CaseController::class, 'uploadImage']);
        
        // تقييمات الحالة
        Route::get('/{id}/evaluations', [CaseController::class, 'evaluations']);
        
        // تقييم الحالة (للمشرفين)
        Route::post('/{id}/evaluate', [CaseController::class, 'evaluate'])
            ->middleware('role:supervisor,admin,ayham');
    });
    
    // تقييم من QR
    Route::post('/evaluations/qr', [CaseController::class, 'evaluateFromQr'])
        ->middleware('role:supervisor,admin,ayham');
    
    // -------------------------------------------------------------------------
    // Grant Routes - مسارات المنح
    // -------------------------------------------------------------------------
    Route::prefix('grants')->group(function () {
        // قائمة المنح
        Route::get('/', [GrantController::class, 'index']);
        
        // إنشاء منحة
        Route::post('/', [GrantController::class, 'store']);
        
        // قبول المنحة
        Route::put('/{id}/accept', [GrantController::class, 'accept']);
        
        // رفض المنحة
        Route::put('/{id}/reject', [GrantController::class, 'reject']);
        
        // إلغاء المنحة
        Route::put('/{id}/cancel', [GrantController::class, 'cancel']);
    });
    
    // -------------------------------------------------------------------------
    // Stats Routes - مسارات الإحصائيات
    // -------------------------------------------------------------------------
    Route::get('/stats', [StatsController::class, 'index']);
    
    // -------------------------------------------------------------------------
    // Course Routes - مسارات المقررات
    // -------------------------------------------------------------------------
    Route::prefix('courses')->group(function () {
        // قائمة المقررات
        Route::get('/', [CourseController::class, 'index']);
        
        // تفاصيل المقرر
        Route::get('/{id}', [CourseController::class, 'show']);
        
        // أعمال المقرر
        Route::get('/{id}/works', [CourseController::class, 'works']);
        
        // جدول المقرر
        Route::get('/{id}/schedule', [CourseController::class, 'schedule']);
    });
    
    // -------------------------------------------------------------------------
    // Admin Routes - مسارات الإدارة (للمشرفين فقط)
    // -------------------------------------------------------------------------
    Route::prefix('admin')->middleware('role:admin,ayham')->group(function () {
        // رموز OTP النشطة
        Route::get('/otp-codes', [AuthController::class, 'activeOtpCodes']);
        
        // سجل المراقبة
        Route::get('/audit-log', [AuthController::class, 'auditLog']);
        
        // إحصائيات النظام
        Route::get('/stats', [StatsController::class, 'adminStats']);
        
        // إدارة المستخدمين
        Route::get('/users', [AuthController::class, 'users']);
        Route::post('/users', [AuthController::class, 'createUser']);
        Route::put('/users/{id}', [AuthController::class, 'updateUser']);
        Route::delete('/users/{id}', [AuthController::class, 'deleteUser']);
    });
    
    // -------------------------------------------------------------------------
    // Supervisor Routes - مسارات المشرفين (للمشرفين السريريين)
    // -------------------------------------------------------------------------
    Route::prefix('supervisor')->middleware('role:supervisor,admin,ayham')->group(function () {
        // جميع الحالات المعلقة
        Route::get('/pending-cases', [CaseController::class, 'pendingCases']);
        
        // جميع الحالات
        Route::get('/all-cases', [CaseController::class, 'allCases']);
        
        // إحصائيات التقييم
        Route::get('/evaluation-stats', [StatsController::class, 'evaluationStats']);
    });
});

// =============================================================================
// Error Handling - معالجة الأخطاء
// =============================================================================

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'المسار غير موجود.',
        'code' => 'ROUTE_NOT_FOUND'
    ], 404);
});
