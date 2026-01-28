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
        // Update master_klasifikasi
        Schema::table('master_klasifikasi', function (Blueprint $table) {
            if (Schema::hasColumn('master_klasifikasi', 'jenis_jra')) {
                $table->dropColumn('jenis_jra');
            }
            if (!Schema::hasColumn('master_klasifikasi', 'hak_akses')) {
                $table->string('hak_akses')->nullable()->after('tindakan_akhir');
            }
        });

        // Update arsip
        Schema::table('arsip', function (Blueprint $table) {
            if (!Schema::hasColumn('arsip', 'unit_pengolah')) {
                $table->string('unit_pengolah')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('arsip', 'hak_akses')) {
                $table->string('hak_akses')->nullable()->after('klasifikasi_id');
            }
            if (Schema::hasColumn('arsip', 'isi_berkas')) {
                $table->dropColumn('isi_berkas');
            }
        });

        // Create isi_arsip
        Schema::dropIfExists('isi_arsip'); // Reset to ensure correct type
        Schema::create('isi_arsip', function (Blueprint $table) {
            $table->id();
            // Match arsip.id type (int(11) signed based on debug output)
            $table->integer('arsip_id'); 
            $table->foreign('arsip_id')->references('id')->on('arsip')->onDelete('cascade');
            $table->text('isi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isi_arsip');

        Schema::table('arsip', function (Blueprint $table) {
            if (!Schema::hasColumn('arsip', 'isi_berkas')) {
                $table->text('isi_berkas')->nullable();
            }
            if (Schema::hasColumn('arsip', 'unit_pengolah')) {
                $table->dropColumn('unit_pengolah');
            }
            if (Schema::hasColumn('arsip', 'hak_akses')) {
                $table->dropColumn('hak_akses');
            }
        });

        Schema::table('master_klasifikasi', function (Blueprint $table) {
            if (Schema::hasColumn('master_klasifikasi', 'hak_akses')) {
                $table->dropColumn('hak_akses');
            }
            if (!Schema::hasColumn('master_klasifikasi', 'jenis_jra')) {
                $table->string('jenis_jra')->nullable();
            }
        });
    }
};
