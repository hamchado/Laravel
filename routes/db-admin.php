<?php

use Illuminate\Support\Facades\Route;

// حماية بواسطة middleware بسيط
Route::get('/db-admin', function () {
    // تحقق من IP محلي فقط
    if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
        abort(403, 'Access denied');
    }
    
    return view('db-admin.index');
})->name('db-admin');

Route::post('/db-admin/login', function () {
    session(['db_admin_logged_in' => true]);
    return redirect('/db-admin/panel');
});

Route::get('/db-admin/panel', function () {
    if (!session('db_admin_logged_in')) {
        return view('db-admin.login');
    }
    
    // بيانات الاتصال
    $connection = [
        'host' => '127.0.0.1',
        'port' => 5432,
        'dbname' => 'multaqa platform',
        'username' => 'u0_a353',
        'password' => '',
    ];
    
    return view('db-admin.panel', compact('connection'));
});
