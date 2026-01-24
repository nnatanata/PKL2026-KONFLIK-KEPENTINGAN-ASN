<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pegawai')->insert([
            [
                'nip' => '198501012010011001',
                'nama' => 'Budi Santoso',
                'jabatan' => 'Staf Administrasi',
                'divisi' => 'Kepegawaian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '198101012010011001',
                'nama' => 'Risnawati',
                'jabatan' => 'Manager Keuangan',
                'divisi' => 'Keuangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '197912122005021002',
                'nama' => 'Siti Aminah',
                'jabatan' => 'Verifikator Laporan',
                'divisi' => 'Pengawasan Internal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '197505052003031003',
                'nama' => 'Ahmad Fauzan',
                'jabatan' => 'Inspektur',
                'divisi' => 'Inspektorat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}