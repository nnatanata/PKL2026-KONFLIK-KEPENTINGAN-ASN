<?php

namespace App\Http\Controllers\Inspektorat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        //menghitung laporan yang disetujui verifikator
        $disetujui = DB::table('laporan_aktual')
            ->where('status_aktual', 'Disetujui')
            ->whereNull('deleted_at')
            ->count() 
            + DB::table('laporan_potensial')
            ->where('status_potensial', 'Disetujui')
            ->whereNull('deleted_at')
            ->count();

        //menghitung laporan yang disetujui inspektorat
        $diproses = DB::table('laporan_aktual')
            ->where('status_aktual', 'Disetujui Inspektorat')
            ->whereNull('deleted_at')
            ->count() 
            + DB::table('laporan_potensial')
            ->where('status_potensial', 'Disetujui Inspektorat')
            ->whereNull('deleted_at')
            ->count();

        //menghitung laporan yang ditolak inspektorat
        $ditolak = DB::table('laporan_aktual')
            ->where('status_aktual', 'Ditolak Inspektorat')
            ->whereNull('deleted_at')
            ->count() 
            + DB::table('laporan_potensial')
            ->where('status_potensial', 'Ditolak Inspektorat')
            ->whereNull('deleted_at')
            ->count();

        return view('inspektorat.dashboard', compact('disetujui', 'diproses', 'ditolak'));
    }

    public function getChartData(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Oct', 'Nov', 'Des'];
        
        $dataAktual = [];
        $dataPotensial = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            //menghitung semua laporan aktual per bln
            $countAktual = DB::table('laporan_aktual')
                ->whereYear('tanggal_aktual', $tahun)
                ->whereMonth('tanggal_aktual', $bulan)
                ->whereIn('status_aktual', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
                ->whereNull('deleted_at')
                ->count();

            //menghitung semua laporan potensial per bln
            $countPotensial = DB::table('laporan_potensial')
                ->whereYear('tanggal_potensial', $tahun)
                ->whereMonth('tanggal_potensial', $bulan)
                ->whereIn('status_potensial', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
                ->whereNull('deleted_at')
                ->count();

            $dataAktual[] = $countAktual;
            $dataPotensial[] = $countPotensial;
        }

        return response()->json([
            'labels' => $months,
            'aktual' => $dataAktual,
            'potensial' => $dataPotensial
        ]);
    }
}