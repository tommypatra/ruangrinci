<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perawatan extends Model
{
    protected $guarded = ['id'];


    public function uploadPerawatan()
    {
        return $this->hasMany(UploadPerawatan::class);
    }

    public function rincianPerawatan()
    {
        return $this->hasMany(RincianPerawatan::class);
    }

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
