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



        $laporanAktual = LaporanAktual::where('pengguna_id', $userId)
            ->select('judul_aktual as judul', 'status_aktual as status', 'created_at')
            ->latest()
            ->take(5)
            ->get();

        $laporanPotensial = LaporanPotensial::where('pengguna_id', $userId)
            ->select('judul_potensial as judul', 'status_potensial as status', 'created_at')
            ->latest()
            ->take(5)
            ->get();

        $statusTerbaru = $laporanAktual
            ->merge($laporanPotensial)
            ->sortByDesc('created_at')
            ->take(5);

        return view('user.dashboard', compact(
            'diproses',
            'diterima',
            'ditolak',
            'statusTerbaru'
        ));
    }
}
