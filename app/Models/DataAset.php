<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAset extends Model
{
    protected $guarded = ['id'];

    public function jenisAset()
    {
        return $this->belongsTo(JenisAset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asetRuangan()
    {
        return $this->hasMany(AsetRuangan::class);
    }

    public function penggunaAset()
    {
        return $this->hasMany(PenggunaAset::class);
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }

    public function rincianPerawatan()
    {
        return $this->hasMany(RincianPerawatan::class);
    }

    public function pinjamAset()
    {
        return $this->hasMany(PinjamAset::class);
    }
}
