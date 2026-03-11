<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPotensialController extends Controller
{
    public function index(Request $request)
    {
        //join tabel pengguna dan pegawai
        $query = DB::table('laporan_potensial as lp')
            ->join('pengguna as p', 'lp.pengguna_id', '=', 'p.id')
            ->join('pegawai as peg', 'p.pegawai_nip', '=', 'peg.nip')
            ->leftJoin('verifikasi as v', 'lp.verifikasi_id', '=', 'v.id')
            ->select(
                'lp.id',
                'lp.judul_potensial',
                'lp.tanggal_potensial',
                'lp.status_potensial',
                'lp.nama_terduga',
                'lp.divisi_terduga',
                'lp.dugaan_konflik',
                'lp.daftar_keluarga',
                'lp.kepemilikan_saham',
                'lp.aset_investasi',
                'lp.pekerjaan_lain',
                'lp.jabatan_lain',
                'lp.keanggotaan_lain',
                'lp.organisasi_nirlaba',
                'lp.rencana_pensiun',
                'peg.nama as nama_pelapor',
                'peg.nip as nip_pelapor',
                'p.username as username_pelapor',
                'v.status_inspektorat',
                'v.status as status_verifikasi'
            )
            ->whereNull('lp.deleted_at');

        //filter search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('lp.judul_potensial', 'like', "%{$search}%")
                  ->orWhere('lp.nama_terduga', 'like', "%{$search}%")
                  ->orWhere('peg.nama', 'like', "%{$search}%")
                  ->orWhere('lp.dugaan_konflik', 'like', "%{$search}%")
                  ->orWhere('lp.status_potensial', 'like', "%{$search}%");
            });
        }

        //filter date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->where('lp.tanggal_potensial', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->where('lp.tanggal_potensial', '<=', $request->date_to);
        }

        //filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('lp.status_potensial', $request->status);
        }

        //sorting
        $sortBy = $request->get('sort_by', 'lp.tanggal_potensial');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        //pagination
        $laporan = $query->paginate(10)->withQueryString();

        return view('verifikator.konflik-potensial.index', compact('laporan'));
    }

    public function show($id)
    {
        $laporan = DB::table('laporan_potensial as lp')
            ->join('pengguna as p', 'lp.pengguna_id', '=', 'p.id')
            ->join('pegawai as peg_pelapor', 'p.pegawai_nip', '=', 'peg_pelapor.nip')
            ->leftJoin('laporan_potensial_pelaku as lpp', 'lp.id', '=', 'lpp.laporan_potensial_id')
            ->leftJoin('pegawai as peg_terduga', 'lpp.pegawai_nip', '=', 'peg_terduga.nip')
            ->leftJoin('verifikasi as v', 'lp.verifikasi_id', '=', 'v.id')
            ->select(
                'lp.*',
                'peg_pelapor.nama as nama_pelapor',
                'peg_pelapor.nip as nip_pelapor',
                'peg_pelapor.jabatan as jabatan_pelapor',
                'peg_pelapor.divisi as divisi_pelapor',
                'p.username as username_pelapor',
                'p.email as email_pelapor',
                'peg_terduga.nama as nama_terduga_lengkap',
                'peg_terduga.nip as nip_terduga',
                'peg_terduga.jabatan as jabatan_terduga',
                'peg_terduga.divisi as divisi_terduga',
                'v.level as level_verifikasi',
                'v.status as status_verifikasi',
                'v.tanggal as tanggal_verifikasi',
                'v.komentar as komentar_verifikasi',
                'v.rekomendasi as rekomendasi_verifikasi',
                'v.status_inspektorat as status_inspektorat'
            )
            ->where('lp.id', $id)
            ->first();

        if (!$laporan) {
            abort(404, 'Laporan tidak ditemukan');
        }

        // history timeline
        $timeline = [];
        if (!empty($laporan->verifikasi_id)) {
            $timeline = DB::table('history')
                ->where('verifikasi_id', $laporan->verifikasi_id)
                ->orderBy('created_at')
                ->get();
        }

        if (!$laporan->nama_terduga_lengkap) {
            $laporan->nama_terduga_lengkap = $laporan->nama_terduga;
        }

        // build history timeline
        $timeline = [];
        if (!empty($laporan->verifikasi_id)) {
            $timeline = DB::table('history')
                ->where('verifikasi_id', $laporan->verifikasi_id)
                ->orderBy('created_at')
                ->get();
        }

        //filter soft deleted dokumen
        $dokumen = DB::table('dokumen_potensial')
            ->where('laporan_potensial_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('verifikator.konflik-potensial.show', compact('laporan', 'dokumen', 'timeline'));
    }

    public function updateVerifikasi(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:Disetujui,Diproses,Ditolak',
            ]);

            $laporan = DB::table('laporan_potensial as lp')
                ->leftJoin('verifikasi as v', 'lp.verifikasi_id', '=', 'v.id')
                ->select('lp.*', 'v.status_inspektorat')
                ->where('lp.id', $id)
                ->first();
            
            if (!$laporan) {
                return redirect()->back()->with('error', 'Laporan tidak ditemukan');
            }

            if (in_array($laporan->status_inspektorat, ['Disetujui Inspektorat', 'Ditolak Inspektorat'])) {
                return redirect()->back()->with('error', 'Tidak dapat mengubah verifikasi. Laporan sudah diverifikasi oleh Inspektorat.');
            }

            //ensure verifikasi record exists and log history
            $verifikasiId = $laporan->verifikasi_id;
            if ($laporan->verifikasi_id) {
                DB::table('verifikasi')
                    ->where('id', $laporan->verifikasi_id)
                    ->update([
                        'status' => $request->status,
                        'tanggal' => now(),
                        'updated_at' => now(),
                        'updated_by' => auth()->user()->username ?? 'system'
                    ]);
                $verifikasiId = $laporan->verifikasi_id;
            } else {
                $newId = DB::table('verifikasi')->insertGetId([
                    'level' => 'verifikator',
                    'status' => $request->status,
                    'tanggal' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'created_by' => auth()->user()->username ?? 'system',
                    'updated_by' => auth()->user()->username ?? 'system',
                ]);
                DB::table('laporan_potensial')
                    ->where('id', $id)
                    ->update(['verifikasi_id' => $newId]);
                $verifikasiId = $newId;

                DB::table('history')->insert([
                    'verifikasi_id' => $newId,
                    'event' => 'Diproses Verifikator',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            //record decision
            $decisionEvent = $request->status === 'Disetujui' ? 'Diterima Verifikator' : 'Ditolak Verifikator';
            DB::table('history')->insert([
                'verifikasi_id' => $verifikasiId,
                'event' => $decisionEvent,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('laporan_potensial')
                ->where('id', $id)
                ->update([
                    'status_potensial' => $request->status,
                    'updated_at' => now(),
                ]);

            $statusText = $request->status === 'Disetujui' ? 'disetujui' : 'ditolak';
            $alertType = $request->status === 'Disetujui' ? 'approved' : 'rejected';
            
            return redirect()
                ->route('verifikator.konflik-potensial.show', ['id' => $id])
                ->with('success', "Laporan berhasil {$statusText}")
                ->with('type', $alertType);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan verifikasi: ' . $e->getMessage());
        }
    }

    public function updateKomentar(Request $request, $id)
    {
        try {
            $request->validate([
                'komentar' => 'required|string',
            ]);

            $laporan = DB::table('laporan_potensial as lp')
                ->leftJoin('verifikasi as v', 'lp.verifikasi_id', '=', 'v.id')
                ->select('lp.*', 'v.status_inspektorat')
                ->where('lp.id', $id)
                ->first();
            
            if (!$laporan) {
                return redirect()->back()->with('error', 'Laporan tidak ditemukan');
            }

            if (in_array($laporan->status_inspektorat, ['Disetujui Inspektorat', 'Ditolak Inspektorat'])) {
                return redirect()->back()->with('error', 'Tidak dapat mengubah komentar. Laporan sudah diverifikasi oleh Inspektorat.');
            }

            //update or insert komentar
            if ($laporan->verifikasi_id) {
                DB::table('verifikasi')
                    ->where('id', $laporan->verifikasi_id)
                    ->update([
                        'komentar' => $request->komentar,
                        'updated_at' => now(),
                        'updated_by' => auth()->user()->username ?? 'system'
                    ]);
                DB::table('history')->insert([
                    'verifikasi_id' => $laporan->verifikasi_id,
                    'event' => 'Komentar Verifikator',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $newId = DB::table('verifikasi')->insertGetId([
                    'level' => 'verifikator',
                    'status' => 'Diproses',
                    'tanggal' => now(),
                    'komentar' => $request->komentar,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'created_by' => auth()->user()->username ?? 'system',
                    'updated_by' => auth()->user()->username ?? 'system',
                ]);
                DB::table('laporan_potensial')->where('id', $id)
                    ->update(['verifikasi_id' => $newId]);
                DB::table('history')->insert([
                    'verifikasi_id' => $newId,
                    'event' => 'Diproses Verifikator',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return redirect()
                ->route('verifikator.konflik-potensial.show', ['id' => $id])
                ->with('success', 'Komentar berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan komentar: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('laporan_potensial')
                ->where('id', $id)
                ->update([
                    'deleted_at' => now(),
                    'deleted_by' => auth()->user()->username ?? 'system'
                ]);

            return redirect()
                ->route('verifikator.konflik-potensial.index')
                ->with('success', 'Laporan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('verifikator.konflik-potensial.index')
                ->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }
}