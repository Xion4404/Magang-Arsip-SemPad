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
        Schema::table('arsip', function (Blueprint $table) {
            if (!Schema::hasColumn('arsip', 'asli_copy')) {
                $table->string('asli_copy')->nullable();
            }
            if (!Schema::hasColumn('arsip', 'lokasi')) {
                $table->string('lokasi')->nullable();
            }
            if (!Schema::hasColumn('arsip', 'rak')) {
                $table->string('rak')->nullable();
            }
            if (!Schema::hasColumn('arsip', 'tingkat')) {
                $table->string('tingkat')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsip', function (Blueprint $table) {
            //
        });
    }
};
