<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\MonitoringKaryawanController;
use App\Http\Controllers\ArsipMasukController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\ManagementAkunController;

// ==========================================
// 1. HALAMAN UTAMA & DASHBOARD
// ==========================================
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;

// ==========================================
// 1. AUTHENTICATION
// ==========================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// 1b. LANDING PAGE (PUBLIC)
// ==========================================
Route::get('/', [LandingController::class, 'index'])->name('landing');

// ==========================================
// 2. PROTECTED ROUTES (Requires Login)
// ==========================================
Route::middleware(['auth'])->group(function () {

    Route::get('/beranda', [DashboardController::class, 'index'])->name('beranda');

    // ==========================================
    // FITUR PEMINJAMAN (MODUL KAMU)
    // ==========================================
// Route Custom (Wajib di atas resource)
    Route::get('/peminjaman/export', [PeminjamanController::class, 'export']);
    Route::patch('/peminjaman/{id}/complete', [PeminjamanController::class, 'complete']);
    Route::post('/peminjaman/bulk-delete', [PeminjamanController::class, 'bulkDelete']);

    // Route Resource (CRUD Otomatis)
    Route::resource('peminjaman', PeminjamanController::class);


    // ==========================================
// 3. FITUR ARSIP (MASTER DATA)
// ==========================================
// Route Custom
    Route::get('/get-klasifikasi-options', [ArsipController::class, 'getKlasifikasiOptions']);
    Route::get('/arsip/export', [ArsipController::class, 'export']);

    // Akses input arsip lewat: /arsip/create (sesuai standar Laravel)
// Route lama '/input-arsip' kita arahkan ke controller create saja biar rapi
    Route::get('/input-arsip', [ArsipController::class, 'create']);
    Route::post('/input-arsip', [ArsipController::class, 'store']);

    Route::resource('arsip', ArsipController::class);


    // ==========================================
// 4. FITUR ARSIP MASUK (ARSIP DINAMIS/SURAT)
// ==========================================
    Route::get('/arsip-masuk', [ArsipMasukController::class, 'index'])->name('arsip-masuk.index');
    Route::get('/arsip-masuk/create', [ArsipMasukController::class, 'create'])->name('arsip-masuk.create');
    Route::get('/arsip-masuk/get-klasifikasi-options', [ArsipMasukController::class, 'getKlasifikasiOptions'])->name('arsip-masuk.get-klasifikasi-options');
    Route::post('/arsip-masuk', [ArsipMasukController::class, 'store'])->name('arsip-masuk.store');
    Route::get('/arsip-masuk/{id}', [ArsipMasukController::class, 'show'])->name('arsip-masuk.show');

    // Sub-fitur Berkas
    Route::get('/arsip-masuk/{id}/berkas', [ArsipMasukController::class, 'createBerkas'])->name('arsip-masuk.berkas.create');
    Route::post('/arsip-masuk/{id}/berkas', [ArsipMasukController::class, 'storeBerkas'])->name('arsip-masuk.berkas.store');
    Route::get('/arsip-masuk/{id}/berkas/{berkasId}/edit', [ArsipMasukController::class, 'editBerkas'])->name('arsip-masuk.berkas.edit');
    Route::put('/arsip-masuk/{id}/berkas/{berkasId}', [ArsipMasukController::class, 'updateBerkas'])->name('arsip-masuk.berkas.update');
    Route::delete('/arsip-masuk/{id}/berkas/{berkasId}', [ArsipMasukController::class, 'destroyBerkas'])->name('arsip-masuk.berkas.destroy');


    // ==========================================
// 5. FITUR MONITORING KARYAWAN
// ==========================================
    Route::get('/monitoring', [MonitoringKaryawanController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/create', [MonitoringKaryawanController::class, 'create'])->name('monitoring.create');
    Route::post('/monitoring', [MonitoringKaryawanController::class, 'store'])->name('monitoring.store');
    Route::get('/monitoring/{id}/edit', [MonitoringKaryawanController::class, 'edit'])->name('monitoring.edit');
    Route::put('/monitoring/{id}', [MonitoringKaryawanController::class, 'update'])->name('monitoring.update');
    Route::delete('/monitoring/{id}', [MonitoringKaryawanController::class, 'destroy'])->name('monitoring.destroy');
    Route::patch('/monitoring/{id}/advance-stage', [MonitoringKaryawanController::class, 'advanceStage'])->name('monitoring.advance-stage');


    // ==========================================
// 6. FITUR PENGUNJUNG
// ==========================================
    Route::resource('pengunjung', PengunjungController::class);


    // ==========================================
// 7. FITUR MANAGEMENT AKUN
// ==========================================
// ==========================================
    Route::resource('management-akun', ManagementAkunController::class);

    // ==========================================
    // 8. FITUR MANAJEMEN MEDIA
    // ==========================================
    Route::resource('manajemen-media', \App\Http\Controllers\ManajemenMediaController::class);




    // ==========================================
// 7. DEBUGGING (Opsional)
// ==========================================
    Route::get('/debug-php', function () {
        return phpinfo();
    });

    // ==========================================
    // 8. PROFILE
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

}); // End of auth middleware group