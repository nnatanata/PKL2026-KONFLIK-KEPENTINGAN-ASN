<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanPotensialSeeder extends Seeder
{
    public function run(): void
    {
        $laporanPotensial = [];
        
        $nipTerduga = [
            '198505152012031012', '198607202013011013', '198709102014121014', '198811252015011015',
            '198901302016121016', '199003152017011017', '199105202018121018', '199207252019011019',
            '199309102020121020', '199411152021011021', '199503202022121022', '199605252015031023',
            '199707302016011024', '199809152017121025', '199911202018011026', '200001252019121027',
            '199206102015011028', '199308152016121029', '199410202017011030', '199512252018121031',
            '199614302019011032', '199716152020121033', '199818202021011034', '199920252015121035',
            '199405102016011036', '199507152017121037', '199609202018011038', '199711252019121039',
            '199813302020011040', '199915152021121041',
        ];

        $dugaanKonflik = [
            'Keluarga inti bekerja di vendor rekanan BRIN',
            'Kepemilikan saham signifikan di perusahaan terkait proyek BRIN',
            'Rangkap jabatan sebagai komisaris di perusahaan swasta',
            'Memiliki hubungan bisnis dengan rekanan BRIN',
            'Menerima hadiah atau gratifikasi dari vendor',
            'Memiliki usaha sejenis dengan vendor rekanan',
            'Saudara kandung sebagai direksi vendor BRIN',
            'Kepentingan finansial dalam proses tender',
            'Menjadi konsultan eksternal di perusahaan rekanan',
            'Hubungan keluarga dengan pejabat di vendor',
        ];

        $daftarKeluarga = [
            'Istri: Siti Aminah, S.E. (Ibu Rumah Tangga), Anak: Muhammad Rizki (Mahasiswa UI), Anak: Fatimah Zahra (SMA 8 Jakarta)',
            'Suami: Budi Santoso, S.T. (PNS Kementerian PUPR), Anak: Putri Ayu Lestari (Mahasiswa ITB)',
            'Istri: Dewi Lestari, S.Pd., M.Pd. (Guru SMAN 3 Jakarta), Anak: Ahmad Farhan (SD Menteng 01), Anak: Zahra Kamila (TK Islam)',
            'Suami: Agus Wijaya, S.E. (Wiraswasta/Direktur PT Maju Jaya), Anak: Dina Mariana (Mahasiswa Unpad)',
            'Istri: Rina Marlina, S.H. (Pegawai Swasta di PT Bank Mandiri), Orang Tua: H. Mahmud (Pensiunan PNS)',
            'Suami: Hendra Gunawan, dr., Sp.PD (Dokter RSUD Tarakan), Anak: Kevin Ananda (SMP Labschool)',
            'Istri: Linda Sari, S.H., M.Kn. (Notaris), Anak: Anggun Pramesti (Mahasiswa UGM), Anak: Reza Pahlevi (SMA Negeri 1)',
            'Suami: Yusuf Ibrahim, S.E., M.M. (Pengusaha Properti), Mertua: Hj. Fatimah (Pensiunan Guru)',
            'Istri: Maya Kusuma (Ibu Rumah Tangga), Anak: Alif Firdaus (SMP), Anak: Salma Azzahra (SD)',
            'Suami: Andi Wijaya (Pengacara), Anak: Nabila (Mahasiswa), Orang Tua: Drs. Sutomo (Pensiunan)',
        ];

        $kepemilikanSaham = [
            'PT Maju Bersama Teknologi: 15% saham (Rp 750 juta)',
            'PT Karya Mandiri Sejahtera: 25% saham (Rp 1,2 miliar)',
            'CV Sejahtera Abadi: 30% saham (Rp 600 juta)',
            'Tidak ada kepemilikan saham di perusahaan manapun',
            'PT Teknologi Nusantara Digital: 10% saham (Rp 500 juta)',
            'PT Sumber Rejeki Bersama: 20% saham (Rp 900 juta)',
            'CV Cahaya Abadi Sentosa: 40% saham/mayoritas (Rp 1,5 miliar)',
            'PT Mitra Sukses Global: 18% saham (Rp 800 juta)',
        ];

        $asetInvestasi = [
            'Deposito BCA Rp 500 juta, Reksadana Saham Mandiri Rp 200 juta, Obligasi Negara Rp 150 juta',
            'Properti: 2 rumah (Tangerang & Depok) + 1 ruko (Bekasi), Deposito Rp 300 juta',
            'Tidak ada investasi signifikan selain tabungan reguler',
            'Saham publik (BBCA, BBRI, TLKM) Rp 150 juta, Obligasi Korporasi Rp 100 juta',
            'Tanah kavling 1000 m² di Bogor (Rp 800 juta), Deposito Bank Mandiri Rp 400 juta',
            'Reksadana Campuran Rp 300 juta, Emas Antam 500 gram (Rp 550 juta)',
            'Apartemen di Jakarta Selatan (Rp 1,2 miliar), Deposito Rp 250 juta',
            'Tanah pertanian 2 hektar di Jawa Barat (Rp 600 juta), Tabungan Rp 100 juta',
        ];

        $pekerjaanLain = [
            'Dosen tidak tetap di Universitas Swasta (Universitas Pancasila)',
            'Konsultan independen bidang IT dan Sistem Informasi',
            'Tidak ada pekerjaan lain di luar tugas di BRIN',
            'Narasumber pelatihan corporate di beberapa perusahaan',
            'Penulis buku dan artikel jurnal ilmiah (royalti)',
            'Pembicara seminar dan workshop profesional',
            'Trainer freelance untuk pelatihan SDM',
            'Reviewer jurnal internasional (honorarium)',
        ];

        $jabatanLain = [
            'Komisaris PT Karya Mandiri Teknologi (2020-sekarang)',
            'Ketua Yayasan Pendidikan Al-Ikhlas (sejak 2018)',
            'Tidak ada jabatan lain di luar BRIN',
            'Pengurus Koperasi Pegawai BRIN (Ketua Bidang Usaha)',
            'Wakil Ketua Asosiasi Profesi Teknologi Informasi Indonesia',
            'Dewan Pengawas CV Sejahtera Bersama',
            'Ketua RT 05/RW 03 Kelurahan Menteng (2022-2025)',
            'Pengurus Masjid Al-Ikhlas (Bendahara)',
        ];

        $keanggotaanLain = [
            'Anggota IDI (Ikatan Dokter Indonesia), Anggota Ikatan Ahli Kesehatan Masyarakat',
            'Anggota IKA UI (Ikatan Alumni Universitas Indonesia)',
            'Anggota Asosiasi Insinyur Indonesia (PII)',
            'Anggota ISEI (Ikatan Sarjana Ekonomi Indonesia)',
            'Anggota IEEE (Institute of Electrical and Electronics Engineers)',
            'Anggota HIMA (Himpunan Mahasiswa), Anggota Alumni ITB',
            'Tidak ada keanggotaan organisasi profesi',
            'Anggota PPNI (Persatuan Perawat Nasional Indonesia)',
        ];

        $organisasiNirlaba = [
            'Pengurus Yayasan Sosial Peduli Anak Yatim',
            'Donatur tetap Rumah Yatim Indonesia',
            'Relawan aktif di PMI (Palang Merah Indonesia)',
            'Tidak terlibat di organisasi nirlaba',
            'Pengurus Yayasan Pendidikan untuk Anak Kurang Mampu',
            'Volunteer di LSM lingkungan hidup',
        ];

        $rencanaPensiun = [
            'Rencana pensiun pada tahun 2030 (usia 58 tahun)',
            'Rencana pensiun tahun 2028 dengan program pensiun dini',
            'Belum ada rencana pensiun konkret',
            'Rencana pensiun tahun 2032 sesuai batas usia pegawai',
            'Akan pensiun tahun 2029 dan berencana buka usaha konsultan',
        ];

        $this->generateLaporan($laporanPotensial, 2023, 4, 'Disetujui', $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga);
        $this->generateLaporan($laporanPotensial, 2023, 3, 'Diproses', $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga);
        $this->generateLaporan($laporanPotensial, 2023, 3, 'Ditolak', $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga);

        $this->generateLaporan($laporanPotensial, 2024, 6, 'Disetujui', $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga);
        $this->generateLaporan($laporanPotensial, 2024, 5, 'Diproses', $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga);
        $this->generateLaporan($laporanPotensial, 2024, 4, 'Ditolak', $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga);

        $this->generateLaporan($laporanPotensial, 2025, 18, 'Disetujui', $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga);
        $this->generateLaporan($laporanPotensial, 2025, 14, 'Diproses', $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga);
        $this->generateLaporan($laporanPotensial, 2025, 8, 'Ditolak', $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga);

        $this->generateLaporan($laporanPotensial, 2026, 22, 'Disetujui', $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga);
        $this->generateLaporan($laporanPotensial, 2026, 18, 'Diproses', $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga);
        $this->generateLaporan($laporanPotensial, 2026, 10, 'Ditolak', $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga);

        foreach ($laporanPotensial as $laporan) {
            DB::table('laporan_potensial')->insert($laporan);
        }
    }

    private function generateLaporan(&$laporanPotensial, $tahun, $jumlah, $status, $dugaanKonflik, $daftarKeluarga, $kepemilikanSaham, $asetInvestasi, $pekerjaanLain, $jabatanLain, $keanggotaanLain, $organisasiNirlaba, $rencanaPensiun, $nipTerduga)
    {
        static $verifikasiId = 1;
        
        for ($i = 0; $i < $jumlah; $i++) {
            $bulan = rand(1, 12);
            $hari = rand(1, 28);
            $tanggal = Carbon::create($tahun, $bulan, $hari)->format('Y-m-d');
            
            $nip = $nipTerduga[array_rand($nipTerduga)];
            $terduga = DB::table('pegawai')->where('nip', $nip)->first();
            
            if (!$terduga) {
                continue;
            }
            
            $dugaan = $dugaanKonflik[array_rand($dugaanKonflik)];
            
            $pelaporId = rand(12, 41);
            
            $laporanPotensial[] = [
                'judul_potensial' => "Potensi Konflik Kepentingan: {$dugaan}",
                'tanggal_potensial' => $tanggal,
                'status_potensial' => $status,
                'nama_terduga' => $terduga->nama,
                'divisi_terduga' => $terduga->divisi,
                'dugaan_konflik' => $dugaan,
                'daftar_keluarga' => $daftarKeluarga[array_rand($daftarKeluarga)],
                'kepemilikan_saham' => $kepemilikanSaham[array_rand($kepemilikanSaham)],
                'aset_investasi' => $asetInvestasi[array_rand($asetInvestasi)],
                'pekerjaan_lain' => $pekerjaanLain[array_rand($pekerjaanLain)],
                'jabatan_lain' => $jabatanLain[array_rand($jabatanLain)],
                'keanggotaan_lain' => $keanggotaanLain[array_rand($keanggotaanLain)],
                'organisasi_nirlaba' => $organisasiNirlaba[array_rand($organisasiNirlaba)],
                'rencana_pensiun' => $rencanaPensiun[array_rand($rencanaPensiun)],
                'pengguna_id' => $pelaporId,
                'verifikasi_id' => $verifikasiId++,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    }
}