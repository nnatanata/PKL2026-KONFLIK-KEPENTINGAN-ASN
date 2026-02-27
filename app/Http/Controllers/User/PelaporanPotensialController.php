<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pegawai;
use App\Models\LaporanPotensial;
use App\Models\LaporanPotensialPelaku;
use App\Models\DokumenPotensial;
use Carbon\Carbon;

class PelaporanPotensialController extends Controller
{
    public function create()
    {
        $pengguna = Auth::user()->load('pegawai');

        return view('user.pelaporan.potensial.create', compact('pengguna'));
    }

    public function searchPegawaiPotensial(Request $request)
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
            'judul_potensial' => 'required|string|max:255',
            'dugaan_konflik' => 'required',
            'daftar_keluarga' => 'nullable',
            'kepemilikan_saham' => 'nullable',
            'aset_investasi' => 'nullable',
            'pekerjaan_lain' => 'nullable',
            'jabatan_lain' => 'nullable',
            'keanggotaan_lain' => 'nullable',
            'organisasi_nirlaba' => 'nullable',
            'rencana_pensiun' => 'nullable',
            'pegawai_nip_terduga' => 'required|exists:pegawai,nip',
            'dokumen.*' => 'nullable|mimes:pdf,docx,jpg,jpeg,png'
        ]);

        DB::transaction(function () use ($request) {

            $laporan = LaporanPotensial::create([
                'pengguna_id' => Auth::user()->id,
                'judul_potensial' => $request->judul_potensial,
                'tanggal_potensial' => Carbon::now(),
                'nama_terduga' => $request->nama_terduga,
                'divisi_terduga' => Pegawai::where('nip', $request->pegawai_nip_terduga)->value('divisi'),

                'dugaan_konflik' => $request->dugaan_konflik,
                'daftar_keluarga' => $request->daftar_keluarga,
                'kepemilikan_saham' => $request->kepemilikan_saham,
                'aset_investasi' => $request->aset_investasi,
                'pekerjaan_lain' => $request->pekerjaan_lain,
                'jabatan_lain' => $request->jabatan_lain,
                'keanggotaan_lain' => $request->keanggotaan_lain,
                'organisasi_nirlaba' => $request->organisasi_nirlaba,
                'rencana_pensiun' => $request->rencana_pensiun,
                'status_potensial' => 'Diproses',
            ]);

            LaporanPotensialPelaku::create([
                'laporan_potensial_id' => $laporan->id,
                'pegawai_nip' => $request->pegawai_nip_terduga,
            ]);

            if ($request->hasFile('dokumen')) {
                foreach ($request->file('dokumen') as $file) {
                    $path = $file->store('dokumen_potensial', 'public');
                    DokumenPotensial::create([
                        'laporan_potensial_id' => $laporan->id,
                        'nama_file_potensial' => $path,
                        'tipe_doc' => $file->getClientMimeType()
                    ]);
                }
            }
        });

        return redirect()->route('user.dashboard')
            ->with('success', 'Laporan berhasil dikirim');
    }
}