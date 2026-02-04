<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. UPDATE TABEL ARSIP (Tambah Label Keamanan & Unit Pemilik)
        Schema::table('arsip', function (Blueprint $table) {
            if (!Schema::hasColumn('arsip', 'klasifikasi_keamanan')) {
                // Default 'Biasa/Terbuka' agar data lama otomatis dianggap aman
                $table->enum('klasifikasi_keamanan', ['Biasa/Terbuka', 'Terbatas', 'Rahasia'])
                      ->default('Biasa/Terbuka')
                      ->after('jenis_media'); 
            }
            if (!Schema::hasColumn('arsip', 'unit_pengolah')) {
                $table->string('unit_pengolah')->nullable()->after('klasifikasi_keamanan'); 
            }
        });

        // 2. UPDATE TABEL PEMINJAMAN (Simpan Jabatan Peminjam saat transaksi)
        Schema::table('peminjaman', function (Blueprint $table) {
            if (!Schema::hasColumn('peminjaman', 'jabatan_peminjam')) {
                $table->string('jabatan_peminjam')->after('nama_peminjam')->nullable();
            }
            if (!Schema::hasColumn('peminjaman', 'is_approved_khusus')) {
                $table->boolean('is_approved_khusus')->default(false)->after('status');
            }
        });
    }

    public function down(): void
    {
        // Fitur Rollback (Jaga-jaga kalau mau membatalkan perubahan)
        Schema::table('arsip', function (Blueprint $table) {
            $table->dropColumn(['klasifikasi_keamanan', 'unit_pengolah']);
        });
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['jabatan_peminjam', 'is_approved_khusus']);
        });
    }
};