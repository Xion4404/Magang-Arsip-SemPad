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
        Schema::dropIfExists('isi_arsip');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('isi_arsip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_id')->constrained('arsip')->onDelete('cascade');
            $table->text('isi');
            $table->string('tahun')->nullable();
            $table->date('tanggal')->nullable();
            $table->integer('jumlah')->default(1);
            $table->string('no_box')->nullable();
            $table->string('hak_akses')->nullable();
            $table->string('jenis_media')->nullable();
            $table->string('masa_simpan')->nullable();
            $table->string('tindakan_akhir')->nullable();
            $table->timestamps();
        });
    }
};
