<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VerifikasiSeeder extends Seeder
{
    public function run(): void
    {
        $verifikasi = [];
        
        $dataPerTahun = [
            2023 => ['count' => 10, 'disetujui' => 4, 'diproses' => 3, 'ditolak' => 3],
            2024 => ['count' => 15, 'disetujui' => 6, 'diproses' => 5, 'ditolak' => 4],
            2025 => ['count' => 40, 'disetujui' => 18, 'diproses' => 14, 'ditolak' => 8],
            2026 => ['count' => 50, 'disetujui' => 22, 'diproses' => 18, 'ditolak' => 10],
        ];

        $komentarTemplates = [
            'Disetujui' => [
                'Laporan telah diverifikasi dan dinyatakan valid. Terdapat indikasi konflik kepentingan yang perlu ditindaklanjuti sesuai prosedur.',
                'Setelah dilakukan verifikasi mendalam, laporan ini memenuhi kriteria dan bukti-bukti pendukung cukup kuat untuk diproses lebih lanjut.',
                'Verifikasi menunjukkan adanya pelanggaran etika dan konflik kepentingan. Direkomendasikan untuk dilakukan investigasi lebih lanjut.',
                'Dokumen pendukung lengkap dan valid. Laporan dapat diproses ke tahap berikutnya sesuai prosedur yang berlaku.',
            ],
            'Diproses' => [
                'Laporan sedang dalam proses verifikasi. Menunggu kelengkapan dokumen tambahan dari pelapor.',
                'Verifikasi masih memerlukan klarifikasi lebih lanjut terkait beberapa poin dalam laporan.',
                'Sedang dilakukan koordinasi dengan pihak terkait untuk memastikan kebenaran informasi yang dilaporkan.',
                'Proses verifikasi membutuhkan waktu tambahan untuk pendalaman terhadap dokumen-dokumen pendukung.',
            ],
            'Ditolak' => [
                'Setelah dilakukan verifikasi, bukti yang disampaikan tidak cukup kuat untuk dikategorikan sebagai konflik kepentingan.',
                'Laporan tidak memenuhi kriteria konflik kepentingan sesuai dengan regulasi yang berlaku.',
                'Informasi yang disampaikan kurang lengkap dan tidak didukung oleh bukti yang memadai.',
                'Berdasarkan hasil verifikasi, tidak ditemukan indikasi pelanggaran atau konflik kepentingan yang signifikan.',
            ],
        ];

        foreach ($dataPerTahun as $tahun => $data) {
            //disetujui
            for ($i = 0; $i < $data['disetujui']; $i++) {
                $bulan = rand(1, 12);
                $hari = rand(1, 28);
                
                $verifikasi[] = [
                    'level' => 'Verifikator',
                    'status' => 'Disetujui',
                    'tanggal' => Carbon::create($tahun, $bulan, $hari)->format('Y-m-d'),
                    'komentar' => $komentarTemplates['Disetujui'][array_rand($komentarTemplates['Disetujui'])],
                    'rekomendasi' => 'Direkomendasikan untuk tindak lanjut sesuai prosedur penanganan konflik kepentingan.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            //diproses
            for ($i = 0; $i < $data['diproses']; $i++) {
                $bulan = rand(1, 12);
                $hari = rand(1, 28);
                
                $verifikasi[] = [
                    'level' => 'Verifikator',
                    'status' => 'Diproses',
                    'tanggal' => Carbon::create($tahun, $bulan, $hari)->format('Y-m-d'),
                    'komentar' => $komentarTemplates['Diproses'][array_rand($komentarTemplates['Diproses'])],
                    'rekomendasi' => 'Menunggu kelengkapan dokumen tambahan dan konfirmasi dari pihak terkait.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            //ditolak
            for ($i = 0; $i < $data['ditolak']; $i++) {
                $bulan = rand(1, 12);
                $hari = rand(1, 28);
                
                $verifikasi[] = [
                    'level' => 'Verifikator', 
                    'status' => 'Ditolak',
                    'tanggal' => Carbon::create($tahun, $bulan, $hari)->format('Y-m-d'),
                    'komentar' => $komentarTemplates['Ditolak'][array_rand($komentarTemplates['Ditolak'])],
                    'rekomendasi' => 'Perbaiki laporan dengan bukti yang lebih lengkap dan jelas atau lakukan investigasi lebih lanjut.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach ($verifikasi as $v) {
            DB::table('verifikasi')->insert($v);
        }
    }
}