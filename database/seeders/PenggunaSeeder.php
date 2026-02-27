<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            //inspektorat
            [
                'username' => 'bambang.suryanto',
                'email' => '999shofi888@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'inspektorat',
                'pegawai_nip' => '197501012000031001'
            ],
            [
                'username' => 'siti.maryam',
                'email' => 'siti.maryam@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'inspektorat',
                'pegawai_nip' => '197803152001121002'
            ],
            [
                'username' => 'agung.wijayanto',
                'email' => 'agung.wijayanto@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'inspektorat',
                'pegawai_nip' => '198005202002031003'
            ],
            [
                'username' => 'wahyu.hidayat',
                'email' => 'wahyu.hidayat@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'inspektorat',
                'pegawai_nip' => '198209102003121004'
            ],
            [
                'username' => 'sri.wahyuni',
                'email' => 'sri.wahyuni@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'inspektorat',
                'pegawai_nip' => '198407252005012005'
            ],
            
            //verifikator
            [
                'username' => 'ahmad.fauzi',
                'email' => 'fairuzydafameidha@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'verifikator',
                'pegawai_nip' => '198601152006041006'
            ],
            [
                'username' => 'dewi.kusuma',
                'email' => 'dewi.kusuma@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'verifikator',
                'pegawai_nip' => '198803202007011007'
            ],
            [
                'username' => 'rizky.pratama',
                'email' => 'rizky.pratama@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'verifikator',
                'pegawai_nip' => '199005102008121008'
            ],
            [
                'username' => 'rina.marlina',
                'email' => 'rina.marlina@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'verifikator',
                'pegawai_nip' => '199107252009011009'
            ],
            [
                'username' => 'budi.santoso',
                'email' => 'budi.santoso@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'verifikator',
                'pegawai_nip' => '199209152010121010'
            ],
            [
                'username' => 'linda.wijayanti',
                'email' => 'linda.wijayanti@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'verifikator',
                'pegawai_nip' => '199311202011011011'
            ],
            
            //pengguna
            [
                'username' => 'hendra.gunawan',
                'email' => 'hendra.gunawan@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '198505152012031012'
            ],
            [
                'username' => 'maya.anggraini',
                'email' => '99shofi88@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '198607202013011013'
            ],
            [
                'username' => 'yusuf.hidayat',
                'email' => 'yusuf.hidayat@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '198709102014121014'
            ],
            [
                'username' => 'anisa.rahmawati',
                'email' => 'anisa.rahmawati@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '198811252015011015'
            ],
            [
                'username' => 'dedi.kurniawan',
                'email' => 'dedi.kurniawan@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '198901302016121016'
            ],
            [
                'username' => 'putri.amelia',
                'email' => 'putri.amelia@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199003152017011017'
            ],
            [
                'username' => 'eko.prasetyo',
                'email' => 'eko.prasetyo@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199105202018121018'
            ],
            [
                'username' => 'ratna.sari',
                'email' => 'ratna.sari@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199207252019011019'
            ],
            [
                'username' => 'firman.syahputra',
                'email' => 'firman.syahputra@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199309102020121020'
            ],
            [
                'username' => 'laila.sari',
                'email' => 'laila.sari@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199411152021011021'
            ],
            [
                'username' => 'irfan.hakim',
                'email' => 'irfan.hakim@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199503202022121022'
            ],
            [
                'username' => 'nurul.fadilah',
                'email' => 'nurul.fadilah@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199605252015031023'
            ],
            [
                'username' => 'tono.sugiarto',
                'email' => 'tono.sugiarto@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199707302016011024'
            ],
            [
                'username' => 'siti.nurhaliza',
                'email' => 'siti.nurhaliza@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199809152017121025'
            ],
            [
                'username' => 'rudi.hermawan',
                'email' => 'rudi.hermawan@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199911202018011026'
            ],
            [
                'username' => 'fitri.handayani',
                'email' => 'fitri.handayani@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '200001252019121027'
            ],
            [
                'username' => 'agus.prasetyo',
                'email' => 'agus.prasetyo@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199206102015011028'
            ],
            [
                'username' => 'wulan.sari',
                'email' => 'wulan.sari@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199308152016121029'
            ],
            [
                'username' => 'hadi.wijaya',
                'email' => 'hadi.wijaya@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199410202017011030'
            ],
            [
                'username' => 'indah.permata',
                'email' => 'indah.permata@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199512252018121031'
            ],
            [
                'username' => 'joko.susanto',
                'email' => 'joko.susanto@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199614302019011032'
            ],
            [
                'username' => 'kartika.dewi',
                'email' => 'kartika.dewi@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199716152020121033'
            ],
            [
                'username' => 'lukman.hakim',
                'email' => 'lukman.hakim@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199818202021011034'
            ],
            [
                'username' => 'mega.putri',
                'email' => 'mega.putri@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199920252015121035'
            ],
            [
                'username' => 'nanda.pratama',
                'email' => 'nanda.pratama@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199405102016011036'
            ],
            [
                'username' => 'olivia.damayanti',
                'email' => 'olivia.damayanti@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199507152017121037'
            ],
            [
                'username' => 'pandu.wicaksono',
                'email' => 'pandu.wicaksono@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199609202018011038'
            ],
            [
                'username' => 'qori.maulida',
                'email' => 'qori.maulida@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199711252019121039'
            ],
            [
                'username' => 'reza.firmansyah',
                'email' => 'reza.firmansyah@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199813302020011040'
            ],
            [
                'username' => 'siska.amelia',
                'email' => 'siska.amelia@brin.go.id',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
                'pegawai_nip' => '199915152021121041'
            ],
        ];

        foreach ($users as $user) {
            DB::table('pengguna')->insert([
                'username' => $user['username'],
                'email' => $user['email'],
                'password' => $user['password'],
                'role' => $user['role'],
                'pegawai_nip' => $user['pegawai_nip'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}