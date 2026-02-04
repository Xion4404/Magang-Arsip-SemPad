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
        if (!Schema::hasTable('arsip_musnah')) {
            Schema::create('arsip_musnah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('arsip_masuk_id')->nullable();
            $table->string('no_berkas')->nullable();
            $table->unsignedBigInteger('klasifikasi_id')->nullable();
            $table->string('hak_akses')->nullable();
            $table->string('nama_berkas');
            $table->text('isi')->nullable();
            $table->string('jenis_media')->nullable();
            $table->year('tahun');
            $table->date('tanggal_masuk')->nullable();
            $table->integer('jumlah')->default(0);
            $table->string('masa_simpan')->nullable();
            $table->string('tindakan_akhir')->nullable();
            $table->string('no_box')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('unit_pengolah')->nullable();
            
            // Extra columns that might exist or be needed
            $table->string('lokasi')->nullable();
            $table->string('rak')->nullable();
            $table->string('tingkat')->nullable();
            $table->string('asli_copy')->nullable();

            $table->timestamp('deleted_at')->useCurrent();
            $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_musnah');
    }
};
