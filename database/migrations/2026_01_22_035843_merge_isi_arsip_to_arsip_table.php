<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('arsip', function (Blueprint $table) {
            $table->text('isi')->nullable()->after('nama_berkas');
            $table->string('masa_simpan')->nullable()->after('jumlah');
            $table->string('tindakan_akhir')->nullable()->after('masa_simpan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arsip', function (Blueprint $table) {
            $table->dropColumn(['isi', 'masa_simpan', 'tindakan_akhir']);
        });
    }
};
