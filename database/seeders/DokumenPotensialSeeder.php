<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokumenPotensialSeeder extends Seeder
{
    public function run(): void
    {
        $laporanPotensial = DB::table('laporan_potensial')->get();

        $fileTypes = ['pdf', 'jpg', 'png', 'docx', 'jpeg'];

        foreach ($laporanPotensial as $laporan) {
            $jumlahDokumen = rand(2, 5);
            
            for ($i = 1; $i <= $jumlahDokumen; $i++) {
                $fileType = $fileTypes[array_rand($fileTypes)];
                
                DB::table('dokumen_potensial')->insert([
                    'nama_file_potensial' => "LP_{$laporan->id}_dokumen_{$i}.{$fileType}",
                    'tipe_doc' => $fileType,
                    'laporan_potensial_id' => $laporan->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}