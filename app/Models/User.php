<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profil()
    {
        return $this->hasMany(Profil::class);
    }

    public function grupUser()
    {
        return $this->hasMany(GrupUser::class);
    }

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class);
    }

    public function gedung()
    {
        return $this->hasMany(Gedung::class);
    }

    public function jenisAset()
    {
        return $this->hasMany(JenisAset::class);
    }

    public function dataAset()
    {
        return $this->hasMany(DataAset::class);
    }

    public function asetRuangan()
    {
        return $this->hasMany(AsetRuangan::class);
    }

    public function penggunaAset()
    {
        return $this->hasMany(PenggunaAset::class);
    }

    public function upload()
    {
        return $this->hasMany(Upload::class);
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }

    public function pinjamAset()
    {
        return $this->hasMany(PinjamAset::class);
    }

    public function pinjamRuangan()
    {
        return $this->hasMany(PinjamRuangan::class);
    }

    public function pemberitahun()
    {
        return $this->hasMany(Pemberitahuan::class);
    }
}
