<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporanAktual;
use App\Models\LaporanPotensial;

class LaporanController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $aktual = LaporanAktual::select(
                'id',
                'judul_aktual as judul',
                'status_aktual as status',
                'tanggal_aktual as tanggal',
                \DB::raw("'Aktual' as tipe")
            )
            ->where('pengguna_id', $userId);

        $laporan = LaporanPotensial::select(
                'id',
                'judul_potensial as judul',
                'status_potensial as status',
                'tanggal_potensial as tanggal',
                \DB::raw("'Potensial' as tipe")
            )
            ->where('pengguna_id', $userId)
            ->unionAll($aktual)
            ->orderBy('tanggal', 'desc')
            ->paginate(9); 

        return view('user.laporan.index', compact('laporan'));
    }
}
