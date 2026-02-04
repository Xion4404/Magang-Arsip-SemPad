<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $units = [
            'Sistem Manajemen',
            'Internal Audit',
            'Komunikasi & Kesekretariatan',
            'CSR',
            'Hukum',
            'Keamanan',
            'Staf Dept. Komunikasi & Hukum Perusahaan',
            'Bisnis Inkubasi Non Semen',
            'Quality Assurance',
            'SHE',
            'Perencanaan & Evaluasi Produksi',
            'Penunjang Produksi',
            'Quality Control',
            'Staf AFR',
            'Operasi Tambang',
            'Produksi Bahan Baku',
            'Perencanaan & Pengawasan Tambang',
            'WHRPG & Utilitas',
            'Produksi Terak',
            'Produksi Semen',
            'Pabrik Kantong',
            'Pabrik Dumai',
            'Pemeliharaan Mesin',
            'Pemeliharaan Listrik & Instrumen',
            'Maintenance Reliability',
            'Capex',
            'Site Engineering',
            'Project Management',
            'Perencanaan Suku Cadang',
            'TPM Officer',
            'Produksi Mesin & Teknikal Support',
            'Produksi BIP & Aplikasi',
            'Operasional SDM',
            'Sarana Umum',
            'GRC & Internal Control',
            'Kinerja & Anggaran',
            'Keuangan',
            'Akuntansi',
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(['nama_unit' => $unit]);
        }
    }
}
