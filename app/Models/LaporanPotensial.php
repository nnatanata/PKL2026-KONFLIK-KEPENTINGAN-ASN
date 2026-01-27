<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanPotensial extends Model
{
    use SoftDeletes;

    protected $table = 'laporan_potensial';

    protected $fillable = [
        'judul_potensial',
        'tanggal_potensial',
        'status_potensial',
        'nama_terduga',
        'divisi_terduga',
        'dugaan_konflik',
        'daftar_keluarga',
        'kepemilikan_saham',
        'aset_investasi',
        'pekerjaan_lain',
        'jabatan_lain',
        'keanggotaan_lain',
        'organisasi_nirlaba',
        'rencana_pensiun',
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
        return $this->hasMany(DokumenPotensial::class, 'laporan_potensial_id');
    }

    public function pelaku()
    {
        return $this->hasMany(LaporanPotensialPelaku::class, 'laporan_potensial_id');
    }
}
