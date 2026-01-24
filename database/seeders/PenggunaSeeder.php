<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        Pengguna::updateOrCreate(
            ['username' => 'budisantoso'],
            [
                'email' => '999shofi888@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '198501012010011001',
            ]
        );

        Pengguna::updateOrCreate(
            ['username' => 'risnawati'],
            [
                'email' => '99shofi88@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '198101012010011001',
            ]
        );

        Pengguna::updateOrCreate(
            ['username' => 'sitiaminah'],
            [
                'email' => 'fairuzydafameidha@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'verifikator',
                'pegawai_nip' => '197912122005021002',
            ]
        );

        Pengguna::updateOrCreate(
            ['username' => 'ahmadfauzan'],
            [
                'email' => 'shofirnata26@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'inspektorat',
                'pegawai_nip' => '197505052003031003',
            ]
        );
    }
}
