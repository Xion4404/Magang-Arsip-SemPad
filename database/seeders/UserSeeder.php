<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Check if user exists to avoid duplicates
        if (User::count() == 0) {
             // Ensure email is authorized
             $email = 'admin@admin.com';
             if (DB::table('authorized_emails')->where('email', $email)->doesntExist()) {
                 DB::table('authorized_emails')->insert(['email' => $email]);
             }

             User::create([
                'nama' => 'Admin',
                'email' => $email,
                'password' => Hash::make('password'),
                'last_login' => now(),
            ]);
            $this->command->info('User Admin created!');
        } else {
            $this->command->info('User already exists.');
        }
    }
}