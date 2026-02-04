<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat Tabel Baru untuk menampung banyak arsip
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->id();
            
            // Hubungkan ke peminjaman utama
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->onDelete('cascade');

            // Jika pilih dari Database (Dropdown)
            $table->foreignId('arsip_id')->nullable()->constrained('arsip')->onDelete('set null');

            // Jika Input Manual (Text)
            $table->string('nama_arsip')->nullable();
            $table->string('no_arsip')->nullable();
            $table->string('no_box')->nullable();

            // Kolom Tambahan (Sesuai Frontend)
            $table->string('hak_akses')->default('Biasa'); 
            $table->string('jenis_arsip')->default('Softfile'); 
            $table->string('detail_fisik')->nullable(); 

            $table->timestamps();
        });

        // 2. Update Tabel Peminjaman (Parent) agar support multiple upload
        Schema::table('peminjaman', function (Blueprint $table) {
            // Ubah bukti_peminjaman jadi TEXT
            $table->text('bukti_peminjaman')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};