<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $pegawai = [
            //inspektorat
            ['nip' => '197501012000031001', 'nama' => 'Dr. H. Bambang Suryanto, S.E., M.M., Ak.', 'jabatan' => 'Inspektur Utama', 'divisi' => 'Inspektorat'],
            ['nip' => '197803152001121002', 'nama' => 'Dra. Hj. Siti Maryam, M.Si.', 'jabatan' => 'Inspektur Bidang I', 'divisi' => 'Inspektorat'],
            ['nip' => '198005202002031003', 'nama' => 'Dr. Ir. Agung Wijayanto, M.T.', 'jabatan' => 'Inspektur Bidang II', 'divisi' => 'Inspektorat'],
            ['nip' => '198209102003121004', 'nama' => 'Drs. Wahyu Hidayat, M.M.', 'jabatan' => 'Auditor Ahli Madya', 'divisi' => 'Inspektorat'],
            ['nip' => '198407252005012005', 'nama' => 'Sri Wahyuni, S.E., M.Ak.', 'jabatan' => 'Auditor Ahli Muda', 'divisi' => 'Inspektorat'],
            
            //verifikator
            ['nip' => '198601152006041006', 'nama' => 'Ahmad Fauzi, S.H., M.H.', 'jabatan' => 'Verifikator Senior', 'divisi' => 'Kepegawaian'],
            ['nip' => '198803202007011007', 'nama' => 'Dewi Kusuma Wardani, S.E., M.M.', 'jabatan' => 'Verifikator Senior', 'divisi' => 'Keuangan'],
            ['nip' => '199005102008121008', 'nama' => 'Rizky Pratama, S.Kom., M.Kom.', 'jabatan' => 'Verifikator', 'divisi' => 'IT'],
            ['nip' => '199107252009011009', 'nama' => 'Rina Marlina, S.Psi., M.Psi.', 'jabatan' => 'Verifikator', 'divisi' => 'SDM'],
            ['nip' => '199209152010121010', 'nama' => 'Budi Santoso, S.T., M.T.', 'jabatan' => 'Verifikator', 'divisi' => 'Teknik'],
            ['nip' => '199311202011011011', 'nama' => 'Linda Wijayanti, S.Sos., M.Si.', 'jabatan' => 'Verifikator', 'divisi' => 'Humas'],
            
            //pegawai biasa
            ['nip' => '198505152012031012', 'nama' => 'Hendra Gunawan, S.Kom.', 'jabatan' => 'Kepala Seksi IT', 'divisi' => 'IT'],
            ['nip' => '198607202013011013', 'nama' => 'Maya Anggraini, S.E.', 'jabatan' => 'Kepala Seksi Anggaran', 'divisi' => 'Keuangan'],
            ['nip' => '198709102014121014', 'nama' => 'Yusuf Hidayat, S.T.', 'jabatan' => 'Staff Teknis Senior', 'divisi' => 'Teknik'],
            ['nip' => '198811252015011015', 'nama' => 'Anisa Rahmawati, S.Pd., M.Pd.', 'jabatan' => 'Kepala Seksi Diklat', 'divisi' => 'Pendidikan'],
            ['nip' => '198901302016121016', 'nama' => 'Dedi Kurniawan, S.H.', 'jabatan' => 'Staff Hukum', 'divisi' => 'Hukum'],
            ['nip' => '199003152017011017', 'nama' => 'Putri Amelia, S.E.', 'jabatan' => 'Staff Administrasi', 'divisi' => 'Kepegawaian'],
            ['nip' => '199105202018121018', 'nama' => 'Eko Prasetyo, S.Si., M.Si.', 'jabatan' => 'Peneliti', 'divisi' => 'Penelitian'],
            ['nip' => '199207252019011019', 'nama' => 'Ratna Sari, S.Pd.', 'jabatan' => 'Staff Pendidikan', 'divisi' => 'Pendidikan'],
            ['nip' => '199309102020121020', 'nama' => 'Firman Syahputra, S.T.', 'jabatan' => 'Staff Pengadaan', 'divisi' => 'Pengadaan'],
            ['nip' => '199411152021011021', 'nama' => 'Laila Sari Dewi, S.Sos.', 'jabatan' => 'Staff Humas', 'divisi' => 'Humas'],
            ['nip' => '199503202022121022', 'nama' => 'Irfan Hakim, S.E.', 'jabatan' => 'Staff Keuangan', 'divisi' => 'Keuangan'],
            ['nip' => '199605252015031023', 'nama' => 'Nurul Fadilah, S.Kom.', 'jabatan' => 'Programmer', 'divisi' => 'IT'],
            ['nip' => '199707302016011024', 'nama' => 'Tono Sugiarto, S.T.', 'jabatan' => 'Supervisor Teknik', 'divisi' => 'Teknik'],
            ['nip' => '199809152017121025', 'nama' => 'Siti Nurhaliza, S.E., M.M.', 'jabatan' => 'Kepala Bidang Keuangan', 'divisi' => 'Keuangan'],
            ['nip' => '199911202018011026', 'nama' => 'Rudi Hermawan, S.Si.', 'jabatan' => 'Analis Data', 'divisi' => 'Penelitian'],
            ['nip' => '200001252019121027', 'nama' => 'Fitri Handayani, S.Psi.', 'jabatan' => 'Staff Rekrutmen', 'divisi' => 'SDM'],
            ['nip' => '199206102015011028', 'nama' => 'Agus Prasetyo, S.T., M.T.', 'jabatan' => 'Kepala Seksi Pengadaan', 'divisi' => 'Pengadaan'],
            ['nip' => '199308152016121029', 'nama' => 'Wulan Sari, S.E.', 'jabatan' => 'Staff Anggaran', 'divisi' => 'Keuangan'],
            ['nip' => '199410202017011030', 'nama' => 'Hadi Wijaya, S.H., M.H.', 'jabatan' => 'Kepala Seksi Hukum', 'divisi' => 'Hukum'],
            ['nip' => '199512252018121031', 'nama' => 'Indah Permata Sari, S.Kom.', 'jabatan' => 'System Analyst', 'divisi' => 'IT'],
            ['nip' => '199614302019011032', 'nama' => 'Joko Susanto, S.T.', 'jabatan' => 'Staff Maintenance', 'divisi' => 'Teknik'],
            ['nip' => '199716152020121033', 'nama' => 'Kartika Dewi, S.Pd.', 'jabatan' => 'Instruktur Pelatihan', 'divisi' => 'Pendidikan'],
            ['nip' => '199818202021011034', 'nama' => 'Lukman Hakim, S.E.', 'jabatan' => 'Staff Verifikasi Keuangan', 'divisi' => 'Keuangan'],
            ['nip' => '199920252015121035', 'nama' => 'Mega Putri, S.Sos.', 'jabatan' => 'Humas Senior', 'divisi' => 'Humas'],
            ['nip' => '199405102016011036', 'nama' => 'Nanda Pratama, S.Kom.', 'jabatan' => 'Database Administrator', 'divisi' => 'IT'],
            ['nip' => '199507152017121037', 'nama' => 'Olivia Damayanti, S.E.', 'jabatan' => 'Staff Akuntansi', 'divisi' => 'Keuangan'],
            ['nip' => '199609202018011038', 'nama' => 'Pandu Wicaksono, S.T.', 'jabatan' => 'Staff Perencanaan', 'divisi' => 'Teknik'],
            ['nip' => '199711252019121039', 'nama' => 'Qori Maulida, S.Psi.', 'jabatan' => 'Staff Pengembangan SDM', 'divisi' => 'SDM'],
            ['nip' => '199813302020011040', 'nama' => 'Reza Firmansyah, S.T.', 'jabatan' => 'Koordinator Proyek', 'divisi' => 'Pengadaan'],
            ['nip' => '199915152021121041', 'nama' => 'Siska Amelia, S.E.', 'jabatan' => 'Bendahara', 'divisi' => 'Keuangan'],
        ];

        foreach ($pegawai as $p) {
            DB::table('pegawai')->insert([
                'nip' => $p['nip'],
                'nama' => $p['nama'],
                'jabatan' => $p['jabatan'],
                'divisi' => $p['divisi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}