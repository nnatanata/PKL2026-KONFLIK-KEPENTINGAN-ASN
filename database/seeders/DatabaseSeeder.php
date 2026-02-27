<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    
    public function run(): void
    {
        $this->call([
            PegawaiSeeder::class,
            PenggunaSeeder::class,
            VerifikasiSeeder::class,
            // laporan seeders menciptakan data dummy untuk pengujian
            // hapus atau komentari baris berikut agar tidak lagi mengisi tabel
            // LaporanAktualSeeder::class,
            // LaporanAktualPelakuSeeder::class,
            // LaporanPotensialSeeder::class,
            // LaporanPotensialPelakuSeeder::class,
            DokumenAktualSeeder::class,
            DokumenPotensialSeeder::class
        ]);
    }
}
