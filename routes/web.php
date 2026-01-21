<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\MonitoringKaryawanController;
use App\Http\Controllers\ArsipMasukController;
use App\Http\Controllers\ArsipController;

// ==========================================
// 1. HALAMAN UTAMA & LOGIN
// ==========================================

// Halaman utama langsung buka daftar peminjaman
Route::get('/', [DashboardController::class, 'index']);

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
Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy']);

// Route untuk Halaman Beranda
Route::get('/beranda', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/peminjaman/export', [PeminjamanController::class, 'export']); 

// Baru route resource di bawahnya
Route::resource('peminjaman', PeminjamanController::class);

Route::resource('pengunjung', PengunjungController::class);

// ==========================================
// 3. FITUR MONITORING KARYAWAN
// ==========================================
Route::get('/monitoring', [MonitoringKaryawanController::class, 'index'])->name('monitoring.index');
Route::get('/monitoring/create', [MonitoringKaryawanController::class, 'create'])->name('monitoring.create');
Route::post('/monitoring', [MonitoringKaryawanController::class, 'store'])->name('monitoring.store');
Route::get('/monitoring/{id}/edit', [MonitoringKaryawanController::class, 'edit'])->name('monitoring.edit');
Route::put('/monitoring/{id}', [MonitoringKaryawanController::class, 'update'])->name('monitoring.update');
Route::delete('/monitoring/{id}', [MonitoringKaryawanController::class, 'destroy'])->name('monitoring.destroy');
Route::patch('/monitoring/{id}/advance-stage', [MonitoringKaryawanController::class, 'advanceStage'])->name('monitoring.advance-stage');


// ==========================================
// 4. FITUR ARSIP MASUK
// ==========================================
Route::get('/arsip-masuk', [ArsipMasukController::class, 'index'])->name('arsip-masuk.index');
Route::get('/arsip-masuk/create', [ArsipMasukController::class, 'create'])->name('arsip-masuk.create');
Route::get('/arsip-masuk/{id}', [ArsipMasukController::class, 'show'])->name('arsip-masuk.show');
Route::post('/arsip-masuk', [ArsipMasukController::class, 'store'])->name('arsip-masuk.store');
Route::get('/arsip-masuk/{id}/berkas', [ArsipMasukController::class, 'createBerkas'])->name('arsip-masuk.berkas.create');
Route::post('/arsip-masuk/{id}/berkas', [ArsipMasukController::class, 'storeBerkas'])->name('arsip-masuk.berkas.store');
Route::delete('/arsip-masuk/{id}/berkas/{berkasId}', [ArsipMasukController::class, 'destroyBerkas'])->name('arsip-masuk.berkas.destroy');
Route::get('/arsip-masuk/get-klasifikasi-options', [ArsipMasukController::class, 'getKlasifikasiOptions'])->name('arsip-masuk.get-klasifikasi-options');
Route::get('/arsip-masuk/{id}/berkas/{berkasId}/edit', [ArsipMasukController::class, 'editBerkas'])->name('arsip-masuk.berkas.edit');
Route::put('/arsip-masuk/{id}/berkas/{berkasId}', [ArsipMasukController::class, 'updateBerkas'])->name('arsip-masuk.berkas.update');

// ==========================================
// 5. FITUR ARSIP
// ==========================================
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