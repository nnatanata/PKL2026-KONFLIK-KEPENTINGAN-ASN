<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanAktual extends Model
{
    use SoftDeletes;

    protected $table = 'laporan_aktual';

    protected $fillable = [
        'judul_aktual',
        'tanggal_aktual',
        'status_aktual',
        'nama_pelaku',
        'divisi_pelaku',
        'sumber_konflik',
        'kaitan_konflik',
        'saran_pengendalian',
        'pengguna_id',
        'verifikasi_id'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function verifikasi()
    {
        return $this->belongsTo(Verifikasi::class, 'verifikasi_id');
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenAktual::class, 'laporan_aktual_id');
    }

    public function pelaku()
    {
        return $this->hasMany(LaporanAktualPelaku::class, 'laporan_aktual_id');
    }
}
