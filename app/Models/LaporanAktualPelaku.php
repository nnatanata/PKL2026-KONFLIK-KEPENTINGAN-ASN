<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanAktualPelaku extends Model
{
    use SoftDeletes;

    protected $table = 'laporan_aktual_pelaku';

    protected $fillable = [
        'pegawai_nip',
        'laporan_aktual_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_nip', 'nip');
    }

    public function laporanAktual()
    {
        return $this->belongsTo(LaporanAktual::class, 'laporan_aktual_id');
    }
}
