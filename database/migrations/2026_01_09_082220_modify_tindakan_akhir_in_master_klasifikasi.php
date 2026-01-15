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
        Schema::table('master_klasifikasi', function (Blueprint $table) {
             DB::statement('ALTER TABLE master_klasifikasi MODIFY COLUMN tindakan_akhir VARCHAR(255)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_klasifikasi', function (Blueprint $table) {
            // DB::statement('ALTER TABLE master_klasifikasi MODIFY COLUMN tindakan_akhir ENUM("Permanen", "Musnah")');
        });
    }
};
