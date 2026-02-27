<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanAktualSeeder extends Seeder
{
    public function run(): void
    {
        $laporanAktual = [];
        
        $nipPelaku = [
            '198505152012031012', '198607202013011013', '198709102014121014', '198811252015011015',
            '198901302016121016', '199003152017011017', '199105202018121018', '199207252019011019',
            '199309102020121020', '199411152021011021', '199503202022121022', '199605252015031023',
            '199707302016011024', '199809152017121025', '199911202018011026', '200001252019121027',
            '199206102015011028', '199308152016121029', '199410202017011030', '199512252018121031',
            '199614302019011032', '199716152020121033', '199818202021011034', '199920252015121035',
            '199405102016011036', '199507152017121037', '199609202018011038', '199711252019121039',
            '199813302020011040', '199915152021121041',
        ];

        $sumberKonflik = [
            'Pengadaan Barang dan Jasa',
            'Pengelolaan Anggaran dan Dana',
            'Rekrutmen dan Seleksi Pegawai',
            'Promosi dan Mutasi Jabatan',
            'Penugasan Proyek Strategis',
            'Penilaian Kinerja Pegawai',
            'Pengadaan Sistem Informasi',
            'Tender Pembangunan Gedung',
            'Konsultasi dan Jasa Eksternal',
            'Kerjasama dengan Vendor',
            'Pengadaan Peralatan Laboratorium',
            'Pengelolaan Aset Instansi',
        ];

        $kaitanKonflik = [
            'Istri/suami bekerja sebagai direktur di perusahaan vendor rekanan',
            'Memiliki saham mayoritas (>30%) di perusahaan yang ikut tender',
            'Menjadi komisaris di perusahaan yang menjadi rekanan BRIN',
            'Saudara kandung adalah pemilik perusahaan vendor',
            'Anak bekerja sebagai manager di perusahaan rekanan',
            'Menerima gratifikasi berupa uang dan fasilitas dari vendor',
            'Rangkap jabatan sebagai konsultan di perusahaan terkait proyek',
            'Memiliki kepentingan finansial langsung dalam tender yang diikuti',
            'Kakak/adik menjadi direksi perusahaan yang mengikuti seleksi',
            'Memiliki hubungan bisnis pribadi dengan pemilik vendor',
            'Menerima hadiah mewah dari calon vendor sebelum tender',
            'Istri/suami pemilik CV yang mengikuti pengadaan',
        ];

        $saranPengendalian = [
            'Alihkan penanggung jawab proyek kepada pejabat lain yang tidak memiliki konflik kepentingan',
            'Lakukan audit internal menyeluruh terhadap seluruh proses pengadaan',
            'Pemberhentian sementara dari jabatan hingga investigasi selesai',
            'Investigasi mendalam oleh tim khusus dari Inspektorat',
            'Pengawasan ketat dan monitoring real-time selama proses berlangsung',
            'Pemisahan tugas dan tanggung jawab (segregation of duties)',
            'Rotasi jabatan atau mutasi ke divisi lain',
            'Sanksi administratif sesuai peraturan kepegawaian yang berlaku',
            'Pemutusan kontrak dengan vendor terkait dan blacklist vendor',
            'Pelatihan etika, integritas, dan anti korupsi secara berkala',
            'Penerapan sistem four eyes principle dalam setiap keputusan',
            'Pembentukan tim independen untuk mengawasi pelaksanaan proyek',
        ];

        $this->generateLaporan($laporanAktual, 2023, 4, 'Disetujui', $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku);
        $this->generateLaporan($laporanAktual, 2023, 3, 'Diproses', $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku);
        $this->generateLaporan($laporanAktual, 2023, 3, 'Ditolak', $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku);

        $this->generateLaporan($laporanAktual, 2024, 6, 'Disetujui', $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku);
        $this->generateLaporan($laporanAktual, 2024, 5, 'Diproses', $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku);
        $this->generateLaporan($laporanAktual, 2024, 4, 'Ditolak', $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku);

        $this->generateLaporan($laporanAktual, 2025, 18, 'Disetujui', $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku);
        $this->generateLaporan($laporanAktual, 2025, 14, 'Diproses', $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku);
        $this->generateLaporan($laporanAktual, 2025, 8, 'Ditolak', $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku);

        $this->generateLaporan($laporanAktual, 2026, 22, 'Disetujui', $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku);
        $this->generateLaporan($laporanAktual, 2026, 18, 'Diproses', $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku);
        $this->generateLaporan($laporanAktual, 2026, 10, 'Ditolak', $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku);

        foreach ($laporanAktual as $laporan) {
            DB::table('laporan_aktual')->insert($laporan);
        }
    }

    private function generateLaporan(&$laporanAktual, $tahun, $jumlah, $status, $sumberKonflik, $kaitanKonflik, $saranPengendalian, $nipPelaku)
    {
        static $verifikasiId = 1;
        
        for ($i = 0; $i < $jumlah; $i++) {
            $bulan = rand(1, 12);
            $hari = rand(1, 28);
            $tanggal = Carbon::create($tahun, $bulan, $hari)->format('Y-m-d');
            
            $nip = $nipPelaku[array_rand($nipPelaku)];
            $pelaku = DB::table('pegawai')->where('nip', $nip)->first();
            
            $sumber = $sumberKonflik[array_rand($sumberKonflik)];
            $kaitan = $kaitanKonflik[array_rand($kaitanKonflik)];
            $saran = $saranPengendalian[array_rand($saranPengendalian)];
            
            $pelaporId = rand(12, 41);
            
            $laporanAktual[] = [
                'judul_aktual' => "Konflik Kepentingan Aktual: {$sumber} - {$pelaku->nama}",
                'tanggal_aktual' => $tanggal,
                'status_aktual' => $status,
                'nama_pelaku' => $pelaku->nama,
                'divisi_pelaku' => $pelaku->divisi,
                'sumber_konflik' => $sumber,
                'kaitan_konflik' => $kaitan,
                'saran_pengendalian' => $saran,
                'pengguna_id' => $pelaporId,
                'verifikasi_id' => $verifikasiId++,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    }
}