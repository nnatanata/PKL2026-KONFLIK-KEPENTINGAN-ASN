<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokumenPotensial extends Model
{
    use SoftDeletes;

    protected $table = 'dokumen_potensial';

    protected $fillable = [
        'nama_file_potensial',
        'tipe_doc',
        'laporan_potensial_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function laporanPotensial()
    {
        return $this->belongsTo(LaporanPotensial::class, 'laporan_potensial_id');
    }
}
