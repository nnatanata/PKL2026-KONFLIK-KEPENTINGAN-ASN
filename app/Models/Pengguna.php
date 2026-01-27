<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordCustom;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'pengguna';

    protected $fillable = [
        'email',
        'username',
        'password',
        'role',
        'pegawai_nip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // public function getAuthIdentifierName()
    // {
    //     return 'username';
    // }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_nip', 'nip');
    }

    public function laporanAktual()
    {
        return $this->hasMany(LaporanAktual::class, 'pengguna_id');
    }

    public function laporanPotensial()
    {
        return $this->hasMany(LaporanPotensial::class, 'pengguna_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordCustom($token));
    }
}
