<?php

namespace App\Http\Controllers\Inspektorat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanAktualController extends Controller
{
    public function index(Request $request)
    {
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
            ->whereIn('la.status_aktual', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
            ->whereNull('la.deleted_at');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('la.judul_aktual', 'like', "%{$search}%")
                  ->orWhere('la.nama_pelaku', 'like', "%{$search}%")
                  ->orWhere('peg.nama', 'like', "%{$search}%")
                  ->orWhere('la.sumber_konflik', 'like', "%{$search}%");
            });
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->where('la.tanggal_aktual', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->where('la.tanggal_aktual', '<=', $request->date_to);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('la.status_aktual', $request->status);
        }

        $sortBy = $request->get('sort_by', 'la.tanggal_aktual');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $laporan = $query->paginate(10)->withQueryString();

        return view('inspektorat.konflik-aktual.index', compact('laporan'));
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
                'v.rekomendasi as rekomendasi_verifikasi',
                'v.status_inspektorat as status_inspektorat',
                'v.tanggal_inspektorat as tanggal_inspektorat',
                'v.komentar_inspektorat as komentar_inspektorat',
                'v.rekomendasi_inspektorat as rekomendasi_inspektorat'
            )
            ->where('la.id', $id)
            ->whereIn('la.status_aktual', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
            ->first();

        if (!$laporan) {
            abort(404, 'Laporan tidak ditemukan atau belum disetujui verifikator');
        }

        $dokumen = DB::table('dokumen_aktual')
            ->where('laporan_aktual_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('inspektorat.konflik-aktual.show', compact('laporan', 'dokumen'));
    }

    public function updateVerifikasi(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:Disetujui,Ditolak',
            ]);

            $laporan = DB::table('laporan_aktual')
                ->where('id', $id)
                ->whereIn('status_aktual', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
                ->first();
            
            if (!$laporan) {
                return redirect()->back()->with('error', 'Laporan tidak ditemukan');
            }

            $newStatus = $request->status === 'Disetujui' ? 'Disetujui Inspektorat' : 'Ditolak Inspektorat';
            
            DB::table('laporan_aktual')
                ->where('id', $id)
                ->update([
                    'status_aktual' => $newStatus,
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->username ?? 'system'
                ]);

            if ($laporan->verifikasi_id) {
                DB::table('verifikasi')
                    ->where('id', $laporan->verifikasi_id)
                    ->update([
                        'status_inspektorat' => $newStatus,
                        'tanggal_inspektorat' => now(),
                        'updated_at' => now(),
                    ]);
            }

            $successMessage = $request->status === 'Disetujui' 
                ? 'Laporan berhasil disetujui' 
                : 'Laporan berhasil ditolak';
            
            $type = $request->status === 'Disetujui' ? 'approved' : 'rejected';

            return redirect()
                ->route('inspektorat.konflik-aktual.show', ['id' => $id])
                ->with('success', $successMessage)
                ->with('type', $type);
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengubah status verifikasi: ' . $e->getMessage());
        }
    }

    public function updateKomentar(Request $request, $id)
    {
        try {
            $request->validate([
                'komentar' => 'required|string',
            ]);

            $laporan = DB::table('laporan_aktual')
                ->where('id', $id)
                ->whereIn('status_aktual', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
                ->first();
            
            if (!$laporan) {
                return redirect()->back()->with('error', 'Laporan tidak ditemukan');
            }

            //komentar inspektorat
            if ($laporan->verifikasi_id) {
                DB::table('verifikasi')
                    ->where('id', $laporan->verifikasi_id)
                    ->update([
                        'komentar_inspektorat' => $request->komentar,
                        'updated_at' => now(),
                    ]);
            }

            return redirect()
                ->route('inspektorat.konflik-aktual.show', ['id' => $id])
                ->with('success', 'Komentar berhasil disimpan')
                ->with('type', 'approved');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan komentar: ' . $e->getMessage());
        }
    }

    public function updateRekomendasi(Request $request, $id)
    {
        try {
            $request->validate([
                'rekomendasi' => 'required|string',
            ]);

            $laporan = DB::table('laporan_aktual')
                ->where('id', $id)
                ->whereIn('status_aktual', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
                ->first();
            
            if (!$laporan) {
                return redirect()->back()->with('error', 'Laporan tidak ditemukan');
            }

            //rekomendasi inspektorat
            if ($laporan->verifikasi_id) {
                DB::table('verifikasi')
                    ->where('id', $laporan->verifikasi_id)
                    ->update([
                        'rekomendasi_inspektorat' => $request->rekomendasi,
                        'updated_at' => now(),
                    ]);
            }

            return redirect()
                ->route('inspektorat.konflik-aktual.show', ['id' => $id])
                ->with('success', 'Rekomendasi berhasil disimpan')
                ->with('type', 'approved');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan rekomendasi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('laporan_aktual')
                ->where('id', $id)
                ->whereIn('status_aktual', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
                ->update([
                    'deleted_at' => now(),
                    'deleted_by' => auth()->user()->username ?? 'system'
                ]);

            return redirect()
                ->route('inspektorat.konflik-aktual.index')
                ->with('success', 'Laporan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('inspektorat.konflik-aktual.index')
                ->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $query = DB::table('laporan_aktual as la')
                ->join('pengguna as p', 'la.pengguna_id', '=', 'p.id')
                ->join('pegawai as peg', 'p.pegawai_nip', '=', 'peg.nip')
                ->leftJoin('laporan_aktual_pelaku as lap', 'la.id', '=', 'lap.laporan_aktual_id')
                ->leftJoin('pegawai as peg_pelaku', 'lap.pegawai_nip', '=', 'peg_pelaku.nip')
                ->leftJoin('verifikasi as v', 'la.verifikasi_id', '=', 'v.id')
                ->select(
                    'la.id',
                    'la.judul_aktual',
                    'la.tanggal_aktual',
                    'la.nama_pelaku',
                    'la.divisi_pelaku',
                    'la.sumber_konflik',
                    'la.kaitan_konflik',
                    'la.saran_pengendalian',
                    'peg.nama as nama_pelapor',
                    'peg.nip as nip_pelapor',
                    'peg.jabatan as jabatan_pelapor',
                    'peg.divisi as divisi_pelapor',
                    'peg_pelaku.nip as nip_pelaku',
                    'peg_pelaku.jabatan as jabatan_pelaku',
                    'v.status as status_verifikasi',
                    'v.tanggal as tanggal_verifikasi',
                    'v.komentar as komentar_verifikasi',
                    'v.status_inspektorat',
                    'v.tanggal_inspektorat',
                    'v.komentar_inspektorat',
                    'la.created_at'
                )
                ->whereIn('la.status_aktual', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
                ->whereNull('la.deleted_at');

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('la.judul_aktual', 'like', "%{$search}%")
                    ->orWhere('la.nama_pelaku', 'like', "%{$search}%")
                    ->orWhere('peg.nama', 'like', "%{$search}%")
                    ->orWhere('la.sumber_konflik', 'like', "%{$search}%");
                });
            }

            if ($request->has('date_from') && $request->date_from != '') {
                $query->where('la.tanggal_aktual', '>=', $request->date_from);
            }

            if ($request->has('date_to') && $request->date_to != '') {
                $query->where('la.tanggal_aktual', '<=', $request->date_to);
            }

            if ($request->has('status') && $request->status != '') {
                $query->where('la.status_aktual', $request->status);
            }

            $laporan = $query->orderBy('la.tanggal_aktual', 'desc')->get();

            //buat spreadsheet
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            //buat header
            $headers = [
                'ID',
                'Tanggal Laporan',
                'Waktu Laporan',
                'Judul Konflik',
                'Nama Pelapor',
                'NIP Pelapor',
                'Jabatan Pelapor',
                'Divisi Pelapor',
                'Nama Pelaku',
                'NIP Pelaku',
                'Jabatan Pelaku',
                'Divisi Pelaku',
                'Sumber Konflik',
                'Kaitan Konflik',
                'Saran Pengendalian',
                'Status Verifikasi',
                'Tanggal Verifikasi',
                'Komentar Verifikasi',
                'Status Inspektorat',
                'Tanggal Inspektorat',
                'Komentar Inspektorat'
            ];

            $column = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($column . '1', $header);
                $sheet->getStyle($column . '1')->getFont()->setBold(true);
                $sheet->getStyle($column . '1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFB11217');
                $sheet->getStyle($column . '1')->getFont()->getColor()->setARGB('FFFFFFFF');
                $column++;
            }

            //isi data
            $row = 2;
            foreach ($laporan as $item) {
                $sheet->setCellValue('A' . $row, $item->id);
                $sheet->setCellValue('B' . $row, \Carbon\Carbon::parse($item->tanggal_aktual)->format('d/m/Y'));
                $sheet->setCellValue('C' . $row, \Carbon\Carbon::parse($item->created_at)->format('H:i:s'));
                $sheet->setCellValue('D' . $row, $item->judul_aktual ?? '-');
                $sheet->setCellValue('E' . $row, $item->nama_pelapor);
                $sheet->setCellValue('F' . $row, $item->nip_pelapor);
                $sheet->setCellValue('G' . $row, $item->jabatan_pelapor ?? '-');
                $sheet->setCellValue('H' . $row, $item->divisi_pelapor);
                $sheet->setCellValue('I' . $row, $item->nama_pelaku);
                $sheet->setCellValue('J' . $row, $item->nip_pelaku ?? '-');
                $sheet->setCellValue('K' . $row, $item->jabatan_pelaku ?? '-');
                $sheet->setCellValue('L' . $row, $item->divisi_pelaku);
                $sheet->setCellValue('M' . $row, $item->sumber_konflik);
                $sheet->setCellValue('N' . $row, $item->kaitan_konflik);
                $sheet->setCellValue('O' . $row, $item->saran_pengendalian ?? '-');
                $sheet->setCellValue('P' . $row, $item->status_verifikasi ?? '-');
                $sheet->setCellValue('Q' . $row, $item->tanggal_verifikasi ? \Carbon\Carbon::parse($item->tanggal_verifikasi)->format('d/m/Y H:i') : '-');
                $sheet->setCellValue('R' . $row, $item->komentar_verifikasi ?? '-');
                $sheet->setCellValue('S' . $row, $item->status_inspektorat ?? '-');
                $sheet->setCellValue('T' . $row, $item->tanggal_inspektorat ? \Carbon\Carbon::parse($item->tanggal_inspektorat)->format('d/m/Y H:i') : '-');
                $sheet->setCellValue('U' . $row, $item->komentar_inspektorat ?? '-');
                $row++;
            }

            //auto size kolom
            foreach (range('A', 'U') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            //border
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            $sheet->getStyle('A1:U' . ($row - 1))->applyFromArray($styleArray);

            //buat file
            $filename = 'Laporan_Konflik_Aktual_' . date('Y-m-d_His') . '.xlsx';
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

            //set header buat download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }
}