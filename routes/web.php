<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;

// ==========================================
// 1. HALAMAN UTAMA & LOGIN
// ==========================================

// Halaman utama langsung buka daftar peminjaman
Route::get('/', [PeminjamanController::class, 'index']);

// Halaman Login (Cadangan)
Route::get('/login', function () {
    return view('login');
})->name('login');


// ==========================================
// 2. FITUR PEMINJAMAN (CRUD)
// ==========================================

// Tampilkan Daftar Peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index']);

// Tampilkan Form Tambah
Route::get('/peminjaman/create', [PeminjamanController::class, 'create']);

// Proses Simpan Data Baru (POST)
Route::post('/peminjaman', [PeminjamanController::class, 'store']);

// Proses Ubah Status / Ceklis (PATCH)
Route::patch('/peminjaman/{id}/complete', [PeminjamanController::class, 'complete']);

// Tampilkan Form Edit (GET)
Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit']);

// Proses Update Data (PUT)
Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update']);

// Proses Hapus Data (DELETE)
// Proses Hapus Data (DELETE)
Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy']);


// ==========================================
// 3. FITUR MONITORING KARYAWAN
// ==========================================

use App\Http\Controllers\MonitoringKaryawanController;

Route::get('/monitoring', [MonitoringKaryawanController::class, 'index'])->name('monitoring.index');
Route::get('/monitoring/create', [MonitoringKaryawanController::class, 'create'])->name('monitoring.create');
Route::post('/monitoring', [MonitoringKaryawanController::class, 'store'])->name('monitoring.store');