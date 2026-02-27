<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanAktualPelakuSeeder extends Seeder
{
    public function run(): void
    {
        $laporanAktual = DB::table('laporan_aktual')->get();

        foreach ($laporanAktual as $laporan) {
            $pegawai = DB::table('pegawai')
                ->where('nama', $laporan->nama_pelaku)
                ->first();

            if ($pegawai) {
                DB::table('laporan_aktual_pelaku')->insert([
                    'pegawai_nip' => $pegawai->nip,
                    'laporan_aktual_id' => $laporan->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}