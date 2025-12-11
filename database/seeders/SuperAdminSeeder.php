<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::where('email', 'superadmin@bmn.com')->doesntExist()) {
            
            User::create([
                'nip' => '1234567890', // Isi dengan NIP awal Superadmin
                'name' => 'Super Admin BMN',
                'email' => 'superadmin@bmn.com', // Gunakan email unik untuk admin
                'password' => Hash::make('password'), // Ganti 'password' dengan password yang kuat
                'role' => 'superadmin', // SET ROLE SEBAGAI SUPERADMIN
                'email_verified_at' => now(), // Tandai sudah terverifikasi
            ]);
            
            $this->command->info('Superadmin berhasil dibuat!');
        } else {
            $this->command->info('Superadmin sudah ada.');
        }
    }
}
