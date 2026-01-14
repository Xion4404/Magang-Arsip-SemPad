<?php

namespace Database\Seeders;

use App\Models\Arsip;
use App\Models\MasterKlasifikasi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ArsipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all valid classification IDs
        $klasifikasiIds = MasterKlasifikasi::pluck('id')->toArray();
        if (empty($klasifikasiIds)) {
            $this->command->error('Tabel master_klasifikasi kosong. Jalankan MasterKlasifikasiSeeder terlebih dahulu.');
            return;
        }

        // Get default user
        $userId = User::first()->id ?? 1;

        $data = [];
        $faker = \Faker\Factory::create('id_ID'); // Use Indonesian locale if available

        for ($i = 0; $i < 50; $i++) {
            $year = $faker->numberBetween(2022, 2026);
            $month = $faker->numberBetween(1, 12);
            $day = $faker->numberBetween(1, 28);
            
            $date = Carbon::create($year, $month, $day);
            
            $data[] = [
                'no_berkas' => 'ARS-' . $year . '-' . str_pad($faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
                'klasifikasi_id' => $faker->randomElement($klasifikasiIds),
                'nama_berkas' => $faker->sentence(3),
                'isi_berkas' => $faker->paragraph(1),
                'tahun' => $year,
                'tanggal_masuk' => $date->format('Y-m-d'),
                'jumlah' => $faker->numberBetween(1, 5),
                'no_box' => 'RAK ' . $faker->randomLetter . '-' . str_pad($faker->numberBetween(1, 20), 2, '0', STR_PAD_LEFT),
                'user_id' => $userId,
            ];
        }

        foreach (array_chunk($data, 50) as $chunk) {
            Arsip::insert($chunk);
        }

        $this->command->info('Berhasil membuat 50 data dummy Arsip.');
    }
}
