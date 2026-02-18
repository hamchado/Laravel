<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// ===== مسارات المصادقة =====
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password reset (OTP)
Route::post('/auth/request-otp', [AuthController::class, 'requestOtp'])->name('auth.request-otp');
Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.verify-otp');
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');

// ===== المسارات المحمية =====
Route::middleware('auth')->group(function () {

    // ===== مسارات الطالب =====
    Route::middleware('role:student')->group(function () {
        Route::get('/student/home', [HomeController::class, 'studentIndex']);
        Route::get('/student/{page}', [HomeController::class, 'studentShow']);
    });

    // ===== مسارات admin =====
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/home', [HomeController::class, 'adminIndex']);
        Route::get('/admin/{page}', [HomeController::class, 'adminShow']);
    });

    // ===== مسارات tash (supervisor) =====
    Route::middleware('role:supervisor')->group(function () {
        Route::get('/tash/home', [HomeController::class, 'tashIndex']);
        Route::get('/tash/{page}', [HomeController::class, 'tashShow']);
    });

    // ===== مسارات panorama =====
    Route::get('/panorama/home', [HomeController::class, 'panoramaIndex']);
    Route::get('/panorama/{page}', [HomeController::class, 'panoramaShow']);

    // ===== مسارات ayham =====
    Route::middleware('role:ayham')->group(function () {
        Route::get('/ayham/home', [HomeController::class, 'ayhamIndex']);
        Route::get('/ayham/{page}', [HomeController::class, 'ayhamShow']);
    });
});
