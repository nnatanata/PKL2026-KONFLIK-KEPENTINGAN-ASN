<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokumenAktual extends Model
{
    use SoftDeletes;

    protected $table = 'dokumen_aktual';

    protected $fillable = [
        'nama_file_aktual',
        'tipe_doc',
        'laporan_aktual_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function laporanAktual()
    {
        return $this->belongsTo(LaporanAktual::class, 'laporan_aktual_id');
    }
}