<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokumenAktualSeeder extends Seeder
{
    public function run(): void
    {
        $laporanAktual = DB::table('laporan_aktual')->get();

        $fileTypes = ['pdf', 'jpg', 'png', 'docx', 'jpeg'];

        foreach ($laporanAktual as $laporan) {
            $jumlahDokumen = rand(2, 5);
            
            for ($i = 1; $i <= $jumlahDokumen; $i++) {
                $fileType = $fileTypes[array_rand($fileTypes)];
                
                DB::table('dokumen_aktual')->insert([
                    'nama_file_aktual' => "LA_{$laporan->id}_dokumen_{$i}.{$fileType}",
                    'tipe_doc' => $fileType,
                    'laporan_aktual_id' => $laporan->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}