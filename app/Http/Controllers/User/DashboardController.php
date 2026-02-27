<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LaporanAktual;
use App\Models\LaporanPotensial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // user sees 'Diproses' for new reports and those accepted by verifikator
        $diproses =
            LaporanAktual::where('pengguna_id', $userId)
                ->whereIn('status_aktual', ['Diproses', 'Disetujui'])
                ->count()
            +
            LaporanPotensial::where('pengguna_id', $userId)
                ->whereIn('status_potensial', ['Diproses', 'Disetujui'])
                ->count();

        // final accepted by inspektorat
        $diterima =
            LaporanAktual::where('pengguna_id', $userId)
                ->where('status_aktual', 'Disetujui Inspektorat')
                ->count()
            +
            LaporanPotensial::where('pengguna_id', $userId)
                ->where('status_potensial', 'Disetujui Inspektorat')
                ->count();

        // rejected either by verifikator or inspektorat
        $ditolak =
            LaporanAktual::where('pengguna_id', $userId)
                ->whereIn('status_aktual', ['Ditolak', 'Ditolak Inspektorat'])
                ->count()
            +
            LaporanPotensial::where('pengguna_id', $userId)
                ->whereIn('status_potensial', ['Ditolak', 'Ditolak Inspektorat'])
                ->count();

        $laporanAktual = LaporanAktual::select(
                'id',
                'judul_aktual as judul',
                'status_aktual as status',
                'created_at as waktu',
                DB::raw("'aktual' as tipe")
            )
            ->where('pengguna_id', $userId);

        $statusTerbaru = DB::query()
            ->fromSub(
                LaporanPotensial::select(
                        'id',
                        'judul_potensial as judul',
                        'status_potensial as status',
                        'updated_at as waktu',
                        DB::raw("'potensial' as tipe")
                    )
                    ->where('pengguna_id', $userId)
                    ->unionAll($laporanAktual),
                'laporan'
            )
            ->orderBy('waktu', 'desc') 
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