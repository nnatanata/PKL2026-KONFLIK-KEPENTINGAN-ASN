<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporanAktual;
use App\Models\LaporanPotensial;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $aktual = LaporanAktual::select(
                'id',
                'judul_aktual as judul',
                'status_aktual as status',
                'created_at as waktu',
                DB::raw("'Aktual' as tipe")
            )
            ->where('pengguna_id', $userId);

        $laporan = DB::query()
            ->fromSub(
                LaporanPotensial::select(
                        'id',
                        'judul_potensial as judul',
                        'status_potensial as status',
                        'updated_at as waktu',
                        DB::raw("'Potensial' as tipe")
                    )
                    ->where('pengguna_id', $userId)
                    ->unionAll($aktual),
                'laporan'
            )
            ->orderBy('waktu', 'desc') 
            ->paginate(9);

        return view('user.laporan.index', compact('laporan'));
    }

    public function show(string $tipe, int $id)
    {
        $userId = Auth::id();

        if ($tipe === 'aktual') {
            $laporan = LaporanAktual::where('id', $id)
                ->where('pengguna_id', $userId)
                ->firstOrFail();

            return view('user.laporan.show-aktual', compact('laporan'));
        }

        if ($tipe === 'potensial') {
            $laporan = LaporanPotensial::where('id', $id)
                ->where('pengguna_id', $userId)
                ->firstOrFail();

            return view('user.laporan.show-potensial', compact('laporan'));
        }

        abort(404);
    }
}
