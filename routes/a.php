<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// الصفحة الافتراضية - تحقق من تسجيل الدخول
Route::get('/', function() {
    return view('login');
})->name('login');

// صفحة تسجيل الدخول
Route::get('/login', function() {
    return view('login');
});

// ===== مسارات الطالب =====
Route::prefix('student')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/{page}', [HomeController::class, 'show']);
});

// ===== مسارات مكتب الاستقبال (tash) =====
Route::prefix('tash')->group(function () {
    Route::get('/', function() {
        return view('tash.home');
    });

    Route::get('/home', function() {
        return view('tash.home');
    });

    Route::get('/{page}', function($page) {
        return view("tash.{$page}");
    });
});

// ===== مسارات panorama =====
Route::prefix('panorama')->group(function () {
    Route::get('/', function() {
        return view('panorama.home');
    });

    Route::get('/home', function() {
        return view('panorama.home');
    });

    Route::get('/{page}', function($page) {
        return view("panorama.{$page}");
    });
});

// ===== مسارات admin =====
Route::prefix('admin')->group(function () {
    Route::get('/', function() {
        return view('admin.home');
    });

    Route::get('/home', function() {
        return view('admin.home');
    });

    Route::get('/{page}', function($page) {
        return view("admin.{$page}");
    });
});
