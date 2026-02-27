<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanPotensialPelakuSeeder extends Seeder
{
    public function run(): void
    {
        $laporanPotensial = DB::table('laporan_potensial')->get();

        foreach ($laporanPotensial as $laporan) {
            $pegawai = DB::table('pegawai')
                ->where('nama', $laporan->nama_terduga)
                ->first();

            if ($pegawai) {
                DB::table('laporan_potensial_pelaku')->insert([
                    'pegawai_nip' => $pegawai->nip,
                    'laporan_potensial_id' => $laporan->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $pegawaiSamaDivisi = DB::table('pegawai')
                    ->where('divisi', $laporan->divisi_terduga)
                    ->inRandomOrder()
                    ->first();
                
                if ($pegawaiSamaDivisi) {
                    DB::table('laporan_potensial_pelaku')->insert([
                        'pegawai_nip' => $pegawaiSamaDivisi->nip,
                        'laporan_potensial_id' => $laporan->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}