<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;

// 1. Halaman Utama (/) langsung diarahkan ke Controller Peminjaman
Route::get('/', [PeminjamanController::class, 'index']);

Route::get('/fix-user', function() {
    try {
        if (\App\Models\User::count() == 0) {
            \App\Models\User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);
            return "User Admin created successfully!";
        }
        return "User already exists.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

// 2. Halaman Login kita pindahkan ke alamat '/login' (buat cadangan kalau butuh nanti)
Route::get('/login', function () {
    return view('login');
})->name('login');

use App\Http\Controllers\ArsipController;

// Routes for Arsip
Route::get('/arsip', [ArsipController::class, 'index']);
Route::post('/arsip/export', [ArsipController::class, 'export']); // Handle Export
Route::get('/input-arsip', [ArsipController::class, 'create']);
Route::post('/input-arsip', [ArsipController::class, 'store']);
Route::get('/debug-php', function () {
    echo "PHP Binary: " . PHP_BINARY . "<br>";
    echo "SAPI Name: " . php_sapi_name() . "<br>";
    echo "Loaded INI: " . php_ini_loaded_file() . "<br>";
    echo "GD Loaded: " . (extension_loaded('gd') ? 'YES' : 'NO') . "<br>";
    if (extension_loaded('gd')) {
        print_r(gd_info());
    } else {
        echo "GD extension is NOT loaded.<br>";
        echo "Extension Dir: " . ini_get('extension_dir') . "<br>";
    }
    return;
});