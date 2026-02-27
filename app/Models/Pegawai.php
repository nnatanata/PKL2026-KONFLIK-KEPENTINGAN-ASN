<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use SoftDeletes;

    protected $table = 'pegawai';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'divisi'
    ];

    //pegawai ke pengguna (1:m)
    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'pegawai_nip', 'nip');
    }

    //pegawai ke laporan aktual pelaku (1:m)
    public function laporanAktualPelaku()
    {
        return $this->hasMany(LaporanAktualPelaku::class, 'pegawai_nip', 'nip');
    }

    //pegawai ke laporan potensial pelaku (1:m)
    public function laporanPotensialPelaku()
    {
        return $this->hasMany(LaporanPotensialPelaku::class, 'pegawai_nip', 'nip');
    }
}
