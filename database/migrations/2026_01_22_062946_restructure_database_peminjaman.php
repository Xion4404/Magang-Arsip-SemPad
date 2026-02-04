<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat Tabel Baru
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->onDelete('cascade');
            $table->foreignId('arsip_id')->nullable()->constrained('arsip')->onDelete('set null');
            
            $table->string('nama_arsip')->nullable();
            $table->string('no_arsip')->nullable();
            $table->string('no_box')->nullable();
            $table->string('hak_akses')->default('Biasa');
            $table->string('jenis_arsip')->default('Softfile');
            $table->string('detail_fisik')->nullable();

            $table->timestamps();
        });

        // 2. Update Tabel Lama
        Schema::table('peminjaman', function (Blueprint $table) {
            // Ubah bukti_peminjaman jadi TEXT agar muat banyak file
            $table->text('bukti_peminjaman')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};