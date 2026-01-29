<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        //hitung rekap status laporan
        $disetujui = DB::table('laporan_aktual')
            ->where('status_aktual', 'Disetujui')
            ->count() 
            + DB::table('laporan_potensial')
            ->where('status_potensial', 'Disetujui')
            ->count();

        $diproses = DB::table('laporan_aktual')
            ->where('status_aktual', 'Diproses')
            ->count() 
            + DB::table('laporan_potensial')
            ->where('status_potensial', 'Diproses')
            ->count();

        $ditolak = DB::table('laporan_aktual')
            ->where('status_aktual', 'Ditolak')
            ->count() 
            + DB::table('laporan_potensial')
            ->where('status_potensial', 'Ditolak')
            ->count();

        return view('admin.dashboard', compact('disetujui', 'diproses', 'ditolak'));
    }

    public function getChartData(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Oct', 'Nov', 'Des'];
        
        $dataAktual = [];
        $dataPotensial = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            //hitung laporan aktual perbulan
            $countAktual = DB::table('laporan_aktual')
                ->whereYear('tanggal_aktual', $tahun)
                ->whereMonth('tanggal_aktual', $bulan)
                ->count();

            //hitung laporan potensial per bulan
            $countPotensial = DB::table('laporan_potensial')
                ->whereYear('tanggal_potensial', $tahun)
                ->whereMonth('tanggal_potensial', $bulan)
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