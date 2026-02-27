<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verifikasi extends Model
{
    use SoftDeletes;

    protected $table = 'verifikasi';

    protected $fillable = [
        'level',
        'status',
        'tanggal',
        'komentar',
        'rekomendasi'
    ];

    public function laporanAktual()
    {
        return $this->hasMany(LaporanAktual::class, 'verifikasi_id');
    }

    public function laporanPotensial()
    {
        return $this->hasMany(LaporanPotensial::class, 'verifikasi_id');
    }

    public function history()
    {
        return $this->hasMany(History::class, 'verifikasi_id');
    }
}
