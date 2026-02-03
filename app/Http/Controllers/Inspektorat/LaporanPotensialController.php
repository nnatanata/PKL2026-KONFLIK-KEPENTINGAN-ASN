<?php

namespace App\Http\Controllers\Inspektorat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPotensialController extends Controller
{
    public function index(Request $request)
    {
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
                'p.username as username_pelapor'
            )
            ->whereIn('lp.status_potensial', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
            ->whereNull('lp.deleted_at');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('lp.judul_potensial', 'like', "%{$search}%")
                  ->orWhere('lp.nama_terduga', 'like', "%{$search}%")
                  ->orWhere('peg.nama', 'like', "%{$search}%")
                  ->orWhere('lp.dugaan_konflik', 'like', "%{$search}%");
            });
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->where('lp.tanggal_potensial', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->where('lp.tanggal_potensial', '<=', $request->date_to);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('lp.status_potensial', $request->status);
        }

        $sortBy = $request->get('sort_by', 'lp.tanggal_potensial');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $laporan = $query->paginate(10)->withQueryString();

        return view('inspektorat.konflik-potensial.index', compact('laporan'));
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
                'v.status_inspektorat as status_inspektorat',
                'v.tanggal_inspektorat as tanggal_inspektorat',
                'v.komentar_inspektorat as komentar_inspektorat'
            )
            ->where('lp.id', $id)
            ->whereIn('lp.status_potensial', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
            ->first();

        if (!$laporan) {
            abort(404, 'Laporan tidak ditemukan atau belum disetujui verifikator');
        }

        if (!$laporan->nama_terduga_lengkap) {
            $laporan->nama_terduga_lengkap = $laporan->nama_terduga;
        }

        $dokumen = DB::table('dokumen_potensial')
            ->where('laporan_potensial_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('inspektorat.konflik-potensial.show', compact('laporan', 'dokumen'));
    }

    public function updateVerifikasi(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:Disetujui,Ditolak',
            ]);

            $laporan = DB::table('laporan_potensial')
                ->where('id', $id)
                ->whereIn('status_potensial', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
                ->first();
            
            if (!$laporan) {
                return redirect()->back()->with('error', 'Laporan tidak ditemukan');
            }

            $newStatus = $request->status === 'Disetujui' ? 'Disetujui Inspektorat' : 'Ditolak Inspektorat';
            
            DB::table('laporan_potensial')
                ->where('id', $id)
                ->update([
                    'status_potensial' => $newStatus,
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
                ->route('inspektorat.konflik-potensial.show', ['id' => $id])
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

            $laporan = DB::table('laporan_potensial')
                ->where('id', $id)
                ->whereIn('status_potensial', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
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
                ->route('inspektorat.konflik-potensial.show', ['id' => $id])
                ->with('success', 'Komentar berhasil disimpan')
                ->with('type', 'approved');
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
                ->whereIn('status_potensial', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
                ->update([
                    'deleted_at' => now(),
                    'deleted_by' => auth()->user()->username ?? 'system'
                ]);

            return redirect()
                ->route('inspektorat.konflik-potensial.index')
                ->with('success', 'Laporan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('inspektorat.konflik-potensial.index')
                ->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $query = DB::table('laporan_potensial as lp')
                ->join('pengguna as p', 'lp.pengguna_id', '=', 'p.id')
                ->join('pegawai as peg', 'p.pegawai_nip', '=', 'peg.nip')
                ->leftJoin('laporan_potensial_pelaku as lpp', 'lp.id', '=', 'lpp.laporan_potensial_id')
                ->leftJoin('pegawai as peg_terduga', 'lpp.pegawai_nip', '=', 'peg_terduga.nip')
                ->leftJoin('verifikasi as v', 'lp.verifikasi_id', '=', 'v.id')
                ->select(
                    'lp.id',
                    'lp.judul_potensial',
                    'lp.tanggal_potensial',
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
                    'peg.jabatan as jabatan_pelapor',
                    'peg.divisi as divisi_pelapor',
                    'peg_terduga.nip as nip_terduga',
                    'peg_terduga.jabatan as jabatan_terduga',
                    'v.status as status_verifikasi',
                    'v.tanggal as tanggal_verifikasi',
                    'v.komentar as komentar_verifikasi',
                    'v.status_inspektorat',
                    'v.tanggal_inspektorat',
                    'v.komentar_inspektorat',
                    'lp.created_at'
                )
                ->whereIn('lp.status_potensial', ['Disetujui', 'Disetujui Inspektorat', 'Ditolak Inspektorat'])
                ->whereNull('lp.deleted_at');

            // Apply filters
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('lp.judul_potensial', 'like', "%{$search}%")
                    ->orWhere('lp.nama_terduga', 'like', "%{$search}%")
                    ->orWhere('peg.nama', 'like', "%{$search}%")
                    ->orWhere('lp.dugaan_konflik', 'like', "%{$search}%");
                });
            }

            if ($request->has('date_from') && $request->date_from != '') {
                $query->where('lp.tanggal_potensial', '>=', $request->date_from);
            }

            if ($request->has('date_to') && $request->date_to != '') {
                $query->where('lp.tanggal_potensial', '<=', $request->date_to);
            }

            if ($request->has('status') && $request->status != '') {
                $query->where('lp.status_potensial', $request->status);
            }

            $laporan = $query->orderBy('lp.tanggal_potensial', 'desc')->get();

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
                'Nama Terduga',
                'NIP Terduga',
                'Jabatan Terduga',
                'Divisi Terduga',
                'Dugaan Konflik',
                'Daftar Keluarga',
                'Kepemilikan Saham',
                'Aset & Investasi',
                'Pekerjaan Lain',
                'Jabatan Lain',
                'Keanggotaan Lain',
                'Organisasi Nirlaba',
                'Rencana Pensiun',
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
                $sheet->setCellValue('B' . $row, \Carbon\Carbon::parse($item->tanggal_potensial)->format('d/m/Y'));
                $sheet->setCellValue('C' . $row, \Carbon\Carbon::parse($item->created_at)->format('H:i:s'));
                $sheet->setCellValue('D' . $row, $item->judul_potensial ?? '-');
                $sheet->setCellValue('E' . $row, $item->nama_pelapor);
                $sheet->setCellValue('F' . $row, $item->nip_pelapor);
                $sheet->setCellValue('G' . $row, $item->jabatan_pelapor ?? '-');
                $sheet->setCellValue('H' . $row, $item->divisi_pelapor);
                $sheet->setCellValue('I' . $row, $item->nama_terduga);
                $sheet->setCellValue('J' . $row, $item->nip_terduga ?? '-');
                $sheet->setCellValue('K' . $row, $item->jabatan_terduga ?? '-');
                $sheet->setCellValue('L' . $row, $item->divisi_terduga ?? '-');
                $sheet->setCellValue('M' . $row, $item->dugaan_konflik ?? '-');
                $sheet->setCellValue('N' . $row, $item->daftar_keluarga ?? '-');
                $sheet->setCellValue('O' . $row, $item->kepemilikan_saham ?? '-');
                $sheet->setCellValue('P' . $row, $item->aset_investasi ?? '-');
                $sheet->setCellValue('Q' . $row, $item->pekerjaan_lain ?? '-');
                $sheet->setCellValue('R' . $row, $item->jabatan_lain ?? '-');
                $sheet->setCellValue('S' . $row, $item->keanggotaan_lain ?? '-');
                $sheet->setCellValue('T' . $row, $item->organisasi_nirlaba ?? '-');
                $sheet->setCellValue('U' . $row, $item->rencana_pensiun ?? '-');
                $sheet->setCellValue('V' . $row, $item->status_verifikasi ?? '-');
                $sheet->setCellValue('W' . $row, $item->tanggal_verifikasi ? \Carbon\Carbon::parse($item->tanggal_verifikasi)->format('d/m/Y H:i') : '-');
                $sheet->setCellValue('X' . $row, $item->komentar_verifikasi ?? '-');
                $sheet->setCellValue('Y' . $row, $item->status_inspektorat ?? '-');
                $sheet->setCellValue('Z' . $row, $item->tanggal_inspektorat ? \Carbon\Carbon::parse($item->tanggal_inspektorat)->format('d/m/Y H:i') : '-');
                $sheet->setCellValue('AA' . $row, $item->komentar_inspektorat ?? '-');
                $row++;
            }

            //auto size kolom
            foreach (range('A', 'Z') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            $sheet->getColumnDimension('AA')->setAutoSize(true);

            //borders
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            $sheet->getStyle('A1:AA' . ($row - 1))->applyFromArray($styleArray);

            //buat file
            $filename = 'Laporan_Konflik_Potensial_' . date('Y-m-d_His') . '.xlsx';
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

            //headers buat download
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