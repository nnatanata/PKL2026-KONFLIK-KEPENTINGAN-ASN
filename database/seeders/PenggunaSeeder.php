<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        Pengguna::updateOrInsert(
            ['username' => 'budisantoso'],
            [
                'email' => 'yutgoryos@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '198501012010011001',
            ]
        );

        Pengguna::updateOrInsert(
            ['username' => 'risnawati'],
            [
                'email' => 'ryujisupremacy@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '198101012010011001',
            ]
        );

        Pengguna::updateOrInsert(
            ['username' => 'sitiaminah'],
            [
                'email' => 'yutogoryos@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'verifikator',
                'pegawai_nip' => '197912122005021002',
            ]
        );

        Pengguna::updateOrInsert(
            ['username' => 'ahmadfauzan'],
            [
                'email' => 'tsurayaolivia@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'inspektorat',
                'pegawai_nip' => '197505052003031003',
            ]
        );
    }
}
