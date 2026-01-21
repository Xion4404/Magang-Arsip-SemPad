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
        Schema::table('isi_arsip', function (Blueprint $table) {
            $table->string('masa_simpan')->nullable();
            $table->string('tindakan_akhir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('isi_arsip', function (Blueprint $table) {
            //
        });
    }
};
