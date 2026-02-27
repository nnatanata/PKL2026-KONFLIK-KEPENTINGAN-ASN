<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistorySeeder extends Seeder
{
    public function run(): void
    {
        $verifikasi = DB::table('verifikasi')->get();

        foreach ($verifikasi as $v) {
            $event = 'Verifikasi dibuat';
            if ($v->status) {
                $event = $v->status === 'Disetujui' ? 'Diterima Verifikator' : 'Ditolak Verifikator';
            }
            DB::table('history')->insert([
                'verifikasi_id' => $v->id,
                'event' => $event,
                'created_at' => $v->created_at,
                'updated_at' => $v->updated_at,
            ]);
        }
    }
}