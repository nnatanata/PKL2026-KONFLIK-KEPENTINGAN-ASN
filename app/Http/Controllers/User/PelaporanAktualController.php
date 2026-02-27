<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pegawai;
use App\Models\LaporanAktual;
use App\Models\LaporanAktualPelaku;
use App\Models\DokumenAktual;
use Carbon\Carbon;

class PelaporanAktualController extends Controller
{
        public function create()
    {
        $pengguna = Auth::user()->load('pegawai');

        return view('user.pelaporan.aktual.create', compact('pengguna'));
    }

    public function searchPegawaiAktual(Request $request)
    {
        $q = $request->q;

        return Pegawai::where('nama', 'like', "%$q%")
            ->select('nip', 'nama', 'jabatan', 'divisi')
            ->limit(10)
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_aktual' => 'required|string|max:255',
            'sumber_konflik' => 'required',
            'kaitan_konflik' => 'required',
            'saran_pengendalian' => 'required',
            'pegawai_nip_pelaku' => 'required|exists:pegawai,nip',
            'dokumen.*' => 'nullable|mimes:pdf,docx,jpg,jpeg,png'
        ]);

        DB::transaction(function () use ($request) {

            $laporan = LaporanAktual::create([
                'pengguna_id' => Auth::user()->id,
                'judul_aktual' => $request->judul_aktual,
                'tanggal_aktual' => Carbon::now(),
                'nama_pelaku' => $request->nama_pelaku,
                'divisi_pelaku' => Pegawai::where('nip', $request->pegawai_nip_pelaku)->value('divisi'),

                'sumber_konflik' => $request->sumber_konflik,
                'kaitan_konflik' => $request->kaitan_konflik,
                'saran_pengendalian' => $request->saran_pengendalian,
                'status_aktual' => 'Diproses',
            ]);

            LaporanAktualPelaku::create([
                'laporan_aktual_id' => $laporan->id,
                'pegawai_nip' => $request->pegawai_nip_pelaku,
            ]);

            if ($request->hasFile('dokumen')) {
                foreach ($request->file('dokumen') as $file) {
                    $path = $file->store('dokumen_aktual', 'public');
                    DokumenAktual::create([
                        'laporan_aktual_id' => $laporan->id,
                        'nama_file_aktual' => $path,
                        'tipe_doc' => $file->getClientMimeType()
                    ]);
                }
            }
        });

        return redirect()->route('user.dashboard')
            ->with('success', 'Laporan berhasil dikirim');
    }

}