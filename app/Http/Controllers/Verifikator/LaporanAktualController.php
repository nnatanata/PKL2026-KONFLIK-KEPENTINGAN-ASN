<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanAktualController extends Controller
{
    public function index(Request $request)
    {
        //join tabel pengguna dan pegawai
        $query = DB::table('laporan_aktual as la')
            ->join('pengguna as p', 'la.pengguna_id', '=', 'p.id')
            ->join('pegawai as peg', 'p.pegawai_nip', '=', 'peg.nip')
            ->leftJoin('verifikasi as v', 'la.verifikasi_id', '=', 'v.id')
            ->select(
                'la.id',
                'la.judul_aktual',
                'la.tanggal_aktual',
                'la.status_aktual',
                'la.nama_pelaku',
                'la.divisi_pelaku',
                'la.sumber_konflik',
                'la.kaitan_konflik',
                'la.saran_pengendalian',
                'peg.nama as nama_pelapor',
                'peg.nip as nip_pelapor',
                'p.username as username_pelapor'
            )
            ->whereNull('la.deleted_at');

        //filter search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('la.judul_aktual', 'like', "%{$search}%")
                  ->orWhere('la.nama_pelaku', 'like', "%{$search}%")
                  ->orWhere('peg.nama', 'like', "%{$search}%")
                  ->orWhere('la.sumber_konflik', 'like', "%{$search}%")
                  ->orWhere('la.status_aktual', 'like', "%{$search}%");
            });
        }

        //filter date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->where('la.tanggal_aktual', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->where('la.tanggal_aktual', '<=', $request->date_to);
        }

        //filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('la.status_aktual', $request->status);
        }

        //sorting
        $sortBy = $request->get('sort_by', 'la.tanggal_aktual');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        //pagination
        $laporan = $query->paginate(10)->withQueryString();

        return view('verifikator.konflik-aktual.index', compact('laporan'));
    }

    public function show($id)
    {
        $laporan = DB::table('laporan_aktual as la')
            ->join('pengguna as p', 'la.pengguna_id', '=', 'p.id')
            ->join('pegawai as peg_pelapor', 'p.pegawai_nip', '=', 'peg_pelapor.nip')
            ->leftJoin('laporan_aktual_pelaku as lap', 'la.id', '=', 'lap.laporan_aktual_id')
            ->leftJoin('pegawai as peg_pelaku', 'lap.pegawai_nip', '=', 'peg_pelaku.nip')
            ->leftJoin('verifikasi as v', 'la.verifikasi_id', '=', 'v.id')
            ->select(
                'la.*',
                'peg_pelapor.nama as nama_pelapor',
                'peg_pelapor.nip as nip_pelapor',
                'peg_pelapor.jabatan as jabatan_pelapor',
                'peg_pelapor.divisi as divisi_pelapor',
                'p.username as username_pelapor',
                'p.email as email_pelapor',
                'peg_pelaku.nip as nip_pelaku',
                'peg_pelaku.jabatan as jabatan_pelaku',
                'v.level as level_verifikasi',
                'v.status as status_verifikasi',
                'v.tanggal as tanggal_verifikasi',
                'v.komentar as komentar_verifikasi',
                'v.rekomendasi as rekomendasi_verifikasi'
            )
            ->where('la.id', $id)
            ->first();

        if (!$laporan) {
            abort(404, 'Laporan tidak ditemukan');
        }

        //filter soft deleted documents
        $dokumen = DB::table('dokumen_aktual')
            ->where('laporan_aktual_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('verifikator.konflik-aktual.show', compact('laporan', 'dokumen'));
    }

    public function updateVerifikasi(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:Disetujui,Diproses,Ditolak',
            ]);

            $laporan = DB::table('laporan_aktual')->where('id', $id)->first();
            
            if (!$laporan) {
                return redirect()->back()->with('error', 'Laporan tidak ditemukan');
            }

            //update verifikasi
            if ($laporan->verifikasi_id) {
                DB::table('verifikasi')
                    ->where('id', $laporan->verifikasi_id)
                    ->update([
                        'status' => $request->status,
                        'tanggal' => now(),
                        'updated_at' => now(),
                    ]);
            }

            //update status laporan
            DB::table('laporan_aktual')
                ->where('id', $id)
                ->update([
                    'status_aktual' => $request->status,
                    'updated_at' => now(),
                ]);

            $statusText = $request->status === 'Disetujui' ? 'disetujui' : 'ditolak';
            $alertType = $request->status === 'Disetujui' ? 'approved' : 'rejected';
            
            //redirect success message di tab verifikasi
            return redirect()
                ->route('konflik-aktual.show', [
                    'id' => $id, 
                    'success' => "Laporan berhasil {$statusText}",
                    'type' => $alertType
                ]);
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

            $laporan = DB::table('laporan_aktual')->where('id', $id)->first();
            
            if (!$laporan) {
                return redirect()->back()->with('error', 'Laporan tidak ditemukan');
            }

            //update komentar di verifikasi
            if ($laporan->verifikasi_id) {
                DB::table('verifikasi')
                    ->where('id', $laporan->verifikasi_id)
                    ->update([
                        'komentar' => $request->komentar,
                        'updated_at' => now(),
                    ]);
            }

            //redirect success message di tab verifikasi
            return redirect()
                ->route('konflik-aktual.show', ['id' => $id, 'success' => 'Komentar berhasil disimpan']);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan komentar: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('laporan_aktual')
                ->where('id', $id)
                ->update([
                    'deleted_at' => now(),
                    'deleted_by' => auth()->user()->username ?? 'system'
                ]);

            return redirect()
                ->route('konflik-aktual.index')
                ->with('success', 'Laporan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('konflik-aktual.index')
                ->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }
}