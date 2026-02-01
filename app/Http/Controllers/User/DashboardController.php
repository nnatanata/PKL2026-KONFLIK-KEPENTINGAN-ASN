<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LaporanAktual;
use App\Models\LaporanPotensial;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $diproses =
            LaporanAktual::where('pengguna_id', $userId)->where('status_aktual', 'Diproses')->count()
            +
            LaporanPotensial::where('pengguna_id', $userId)->where('status_potensial', 'Diproses')->count();

        $diterima =
            LaporanAktual::where('pengguna_id', $userId)->where('status_aktual', 'Diterima')->count()
            +
            LaporanPotensial::where('pengguna_id', $userId)->where('status_potensial', 'Diterima')->count();

        $ditolak =
            LaporanAktual::where('pengguna_id', $userId)->where('status_aktual', 'Ditolak')->count()
            +
            LaporanPotensial::where('pengguna_id', $userId)->where('status_potensial', 'Ditolak')->count();


        $laporanAktual = LaporanAktual::select(
                'judul_aktual as judul',
                'status_aktual as status',
                'tanggal_aktual as tanggal'
            )
            ->where('pengguna_id', $userId);

        $statusTerbaru = LaporanPotensial::select(
                'judul_potensial as judul',
                'status_potensial as status',
                'tanggal_potensial as tanggal'
            )
            ->where('pengguna_id', $userId)
            ->unionAll($laporanAktual)
            ->orderBy('tanggal', 'desc')
            ->limit(3)
            ->get();

        return view('user.dashboard', compact(
            'diproses',
            'diterima',
            'ditolak',
            'statusTerbaru'
        ));
    }
}
