<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Menambahkan 3 Kolom Baru
            $table->string('nip')->after('nama_peminjam')->nullable(); // Kolom NIP
            $table->string('jenis_dokumen')->after('arsip_id')->nullable(); // Kolom Jenis Dokumen (Digital/Fisik)
            $table->string('bukti_peminjaman')->after('status')->nullable(); // Kolom untuk path gambar bukti
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn(['nip', 'jenis_dokumen', 'bukti_peminjaman']);
        });
    }
};