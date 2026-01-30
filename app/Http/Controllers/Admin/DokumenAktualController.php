<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenAktual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class DokumenAktualController extends Controller
{
    //download dokumen
    public function download($id)
    {
        $dokumen = DokumenAktual::findOrFail($id);
        
        //path ke file dummy
        $filePath = 'dokumen_aktual/' . $dokumen->nama_file_aktual;
        
        if (!Storage::disk('public')->exists($filePath)) {
            $this->generateDummyFile($dokumen);
        }
        
        $fullPath = Storage::disk('public')->path($filePath);
        
        return Response::download($fullPath, $dokumen->nama_file_aktual);
    }
    
    //view dokumen
    public function view($id)
    {
        $dokumen = DokumenAktual::findOrFail($id);
        
        //path ke file dummy
        $filePath = 'dokumen_aktual/' . $dokumen->nama_file_aktual;
        
        if (!Storage::disk('public')->exists($filePath)) {
            $this->generateDummyFile($dokumen);
        }
        
        $fullPath = Storage::disk('public')->path($filePath);
        $extension = strtolower(pathinfo($dokumen->nama_file_aktual, PATHINFO_EXTENSION));
        
        //menentukan tipe file
        $fileTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        
        $fileType = $fileTypes[$extension] ?? 'application/octet-stream';
        
        //docx konversi ke HTML untuk preview
        if ($extension === 'docx') {
            return $this->viewDocxAsHtml($dokumen, $fullPath);
        }
        
        return Response::file($fullPath, [
            'Content-Type' => $fileType,
            'Content-Disposition' => 'inline; filename="' . $dokumen->nama_file_aktual . '"'
        ]);
    }
    
    //view docx as HTML
    private function viewDocxAsHtml($dokumen, $fullPath)
    {
        try {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($fullPath);
            $htmlWriter = new \PhpOffice\PhpWord\Writer\HTML($phpWord);
            
            ob_start();
            $htmlWriter->save('php://output');
            $htmlContent = ob_get_clean();
            
            $styledHtml = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>' . htmlspecialchars($dokumen->nama_file_aktual) . '</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        padding: 40px;
                        max-width: 800px;
                        margin: 0 auto;
                        background: #f5f5f5;
                    }
                    .document-container {
                        background: white;
                        padding: 60px;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                        border-radius: 8px;
                    }
                    h1, h2, h3, h4, h5, h6 {
                        color: #333;
                        margin-top: 1.5em;
                        margin-bottom: 0.5em;
                    }
                    p {
                        margin: 1em 0;
                        text-align: justify;
                    }
                    table {
                        border-collapse: collapse;
                        width: 100%;
                        margin: 1em 0;
                    }
                    table td, table th {
                        border: 1px solid #ddd;
                        padding: 8px;
                    }
                    table th {
                        background-color: #f2f2f2;
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <div class="document-container">
                    ' . $htmlContent . '
                </div>
            </body>
            </html>';
            
            return response($styledHtml, 200)
                ->header('Content-Type', 'text/html; charset=UTF-8');
                
        } catch (\Exception $e) {
            return response()->view('errors.docx-preview', [
                'message' => 'Tidak dapat menampilkan preview dokumen. Silakan download untuk melihat isi dokumen.',
                'filename' => $dokumen->nama_file_aktual,
                'downloadUrl' => route('dokumen-aktual.download', $dokumen->id)
            ], 200);
        }
    }
    
    //buat dummy file
    private function generateDummyFile($dokumen)
    {
        $extension = strtolower(pathinfo($dokumen->nama_file_aktual, PATHINFO_EXTENSION));
        $filePath = 'dokumen_aktual/' . $dokumen->nama_file_aktual;
        
        if (!Storage::disk('public')->exists('dokumen_aktual')) {
            Storage::disk('public')->makeDirectory('dokumen_aktual');
        }
        
        switch ($extension) {
            case 'pdf':
                $this->generateDummyPDF($dokumen, $filePath);
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
                $this->generateDummyImage($dokumen, $filePath, $extension);
                break;
            case 'docx':
                $this->generateDummyDocx($dokumen, $filePath);
                break;
        }
    }
    
    //buat dummy pdf
    private function generateDummyPDF($dokumen, $filePath)
    {
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'DOKUMEN KONFLIK KEPENTINGAN ASN', 0, 1, 'C');
        $pdf->Ln(10);
        
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'Informasi Dokumen', 0, 1);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(50, 8, 'Nama File:', 0, 0);
        $pdf->Cell(0, 8, $dokumen->nama_file_aktual, 0, 1);
        $pdf->Cell(50, 8, 'Tipe Dokumen:', 0, 0);
        $pdf->Cell(0, 8, $dokumen->tipe_doc, 0, 1);
        $pdf->Cell(50, 8, 'Tanggal Upload:', 0, 0);
        $pdf->Cell(0, 8, $dokumen->created_at->format('d F Y H:i'), 0, 1);
        $pdf->Ln(10);
        
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'Informasi Laporan', 0, 1);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(50, 8, 'ID Laporan:', 0, 0);
        $pdf->Cell(0, 8, '#' . $dokumen->laporan_aktual_id, 0, 1);
        
        if ($dokumen->laporanAktual) {
            $pdf->Cell(50, 8, 'Judul:', 0, 0);
            $pdf->MultiCell(0, 8, $dokumen->laporanAktual->judul_aktual);
            $pdf->Cell(50, 8, 'Tanggal:', 0, 0);
            $pdf->Cell(0, 8, $dokumen->laporanAktual->tanggal_aktual, 0, 1);
        }
        
        $pdf->Ln(10);
        
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->MultiCell(0, 6, 'Ini adalah dokumen dummy yang dibuat otomatis oleh sistem untuk keperluan testing. Ketika sistem user sudah siap, dokumen asli akan di-upload oleh user dan menggantikan file dummy ini.');
        
        $fullPath = Storage::disk('public')->path($filePath);
        $pdf->Output('F', $fullPath);
    }
    
    //buat dummy image
    private function generateDummyImage($dokumen, $filePath, $extension)
    {
        $width = 800;
        $height = 600;
        $image = imagecreatetruecolor($width, $height);
        
        $bgColor = imagecolorallocate($image, 245, 245, 245);
        imagefill($image, 0, 0, $bgColor);
        
        $textColor = imagecolorallocate($image, 50, 50, 50);
        $redColor = imagecolorallocate($image, 177, 18, 23);
        
        $borderColor = imagecolorallocate($image, 177, 18, 23);
        imagerectangle($image, 10, 10, $width - 10, $height - 10, $borderColor);
        imagerectangle($image, 11, 11, $width - 11, $height - 11, $borderColor);
        
        $font = 5;
        
        imagestring($image, $font, 50, 50, 'DOKUMEN KONFLIK KEPENTINGAN ASN', $redColor);
        
        imagestring($image, $font, 50, 100, 'Nama File: ' . $dokumen->nama_file_aktual, $textColor);
        imagestring($image, $font, 50, 130, 'Tipe Dokumen: ' . $dokumen->tipe_doc, $textColor);
        imagestring($image, $font, 50, 160, 'Tanggal: ' . $dokumen->created_at->format('d F Y'), $textColor);
        imagestring($image, $font, 50, 190, 'ID Laporan: #' . $dokumen->laporan_aktual_id, $textColor);
        
        imagestring($image, $font, 50, $height - 100, 'DUMMY DOCUMENT - FOR TESTING ONLY', $textColor);
        imagestring($image, $font, 50, $height - 70, 'File ini akan diganti dengan dokumen asli dari user', $textColor);
        
        $fullPath = Storage::disk('public')->path($filePath);
        
        switch ($extension) {
            case 'png':
                imagepng($image, $fullPath);
                break;
            case 'jpg':
            case 'jpeg':
                imagejpeg($image, $fullPath, 90);
                break;
        }
        
        imagedestroy($image);
    }
    
    //buat dummy docx
    private function generateDummyDocx($dokumen, $filePath)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        
        $section->addTitle('DOKUMEN KONFLIK KEPENTINGAN ASN', 1);
        $section->addTextBreak(2);
        
        $section->addTitle('Informasi Dokumen', 2);
        $section->addText('Nama File: ' . $dokumen->nama_file_aktual);
        $section->addText('Tipe Dokumen: ' . $dokumen->tipe_doc);
        $section->addText('Tanggal Upload: ' . $dokumen->created_at->format('d F Y H:i'));
        $section->addTextBreak(1);
        
        $section->addTitle('Informasi Laporan', 2);
        $section->addText('ID Laporan: #' . $dokumen->laporan_aktual_id);
        
        if ($dokumen->laporanAktual) {
            $section->addText('Judul: ' . $dokumen->laporanAktual->judul_aktual);
            $section->addText('Tanggal: ' . $dokumen->laporanAktual->tanggal_aktual);
        }
        
        $section->addTextBreak(2);
        
        $section->addText(
            'Ini adalah dokumen dummy yang dibuat otomatis oleh sistem untuk keperluan testing. ' .
            'Ketika sistem user sudah siap, dokumen asli akan di-upload oleh user dan menggantikan file dummy ini.',
            ['italic' => true, 'color' => '666666']
        );
        
        $fullPath = Storage::disk('public')->path($filePath);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($fullPath);
    }
}