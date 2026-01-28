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
            // $table->string('masa_simpan')->change();
            DB::statement('ALTER TABLE master_klasifikasi MODIFY COLUMN masa_simpan VARCHAR(255)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_klasifikasi', function (Blueprint $table) {
            // $table->integer('masa_simpan')->change();
            DB::statement('ALTER TABLE master_klasifikasi MODIFY COLUMN masa_simpan INT');
        });
    }
};
