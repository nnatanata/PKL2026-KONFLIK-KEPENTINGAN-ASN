<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanPotensialPelaku extends Model
{
    use SoftDeletes;

    protected $table = 'laporan_potensial_pelaku';

    protected $fillable = [
        'pegawai_nip',
        'laporan_potensial_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_nip', 'nip');
    }

    public function laporanPotensial()
    {
        return $this->belongsTo(LaporanPotensial::class, 'laporan_potensial_id');
    }
}
