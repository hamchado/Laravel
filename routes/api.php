<?php

use App\Http\Controllers\Api\AuditController;
use App\Http\Controllers\Api\CaseController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\GrantController;
use App\Http\Controllers\Api\PanoramaController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\StatsController;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Route;

// All API routes require authentication via web session
Route::middleware('auth')->group(function () {

    // Current user info
    Route::get('/user', function (\Illuminate\Http\Request $request) {
        $user = $request->user()->load('role');
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'student_id' => $user->student_id,
                'phone' => $user->phone,
                'role' => $user->role->name,
                'role_label' => $user->role->label,
            ],
        ]);
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile/password', [ProfileController::class, 'changePassword']);
    Route::put('/profile/phone', [ProfileController::class, 'updatePhone']);

    // Patients
    Route::get('/patients', [PatientController::class, 'index']);
    Route::post('/patients', [PatientController::class, 'store']);
    Route::get('/patients/{patient}', [PatientController::class, 'show']);

    // Panorama
    Route::get('/patients/{patient}/panorama', [PanoramaController::class, 'index']);
    Route::post('/patients/{patient}/panorama', [PanoramaController::class, 'store']);

    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::put('/reservations/{reservation}/confirm', [ReservationController::class, 'confirm']);
    Route::put('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel']);

    // Cases
    Route::get('/cases', [CaseController::class, 'index']);
    Route::post('/cases', [CaseController::class, 'store']);
    Route::get('/cases/session-status', [CaseController::class, 'sessionStatus']);
    Route::get('/cases/{case}', [CaseController::class, 'show']);
    Route::get('/cases/{case}/qr', [CaseController::class, 'qr']);
    Route::post('/images/upload', [CaseController::class, 'uploadImage']);

    // Evaluations
    Route::get('/cases/{case}/evaluations', [EvaluationController::class, 'index']);
    Route::post('/cases/{case}/evaluate', [EvaluationController::class, 'store']);
    Route::post('/evaluations/qr', [EvaluationController::class, 'evaluateFromQr']);
    Route::post('/evaluations/lookup-qr', [EvaluationController::class, 'lookupQr']);

    // Grants
    Route::get('/grants', [GrantController::class, 'index']);
    Route::post('/grants', [GrantController::class, 'store']);
    Route::put('/grants/{grant}/accept', [GrantController::class, 'accept']);
    Route::put('/grants/{grant}/reject', [GrantController::class, 'reject']);
    Route::put('/grants/{grant}/cancel', [GrantController::class, 'cancel']);

    // Stats
    Route::get('/stats', [StatsController::class, 'index']);

    // Courses
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{course}/works', [CourseController::class, 'works']);

    // Admin: OTP codes management
    Route::get('/admin/otp-codes', function (\Illuminate\Http\Request $request) {
        $user = $request->user();
        if (!$user->isAdmin() && !$user->isAyham()) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }

        $codes = OtpCode::with('user:id,name,student_id,phone')
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->orderByDesc('created_at')
            ->get();

        return response()->json(['success' => true, 'codes' => $codes]);
    });

    // Audit Log (admin/ayham only)
    Route::get('/audit-log', [AuditController::class, 'index']);
});
