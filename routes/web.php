<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;

// 1. Halaman Utama (/) langsung diarahkan ke Controller Peminjaman
Route::get('/', [PeminjamanController::class, 'index']);

// 2. Halaman Login kita pindahkan ke alamat '/login' (buat cadangan kalau butuh nanti)
Route::get('/login', function () {
    return view('login');
})->name('login');