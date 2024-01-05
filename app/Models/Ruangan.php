<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $guarded = ['id'];


    public function asetRuangan()
    {
        return $this->hasMany(AsetRuangan::class);
    }

    public function gedung()
    {
        return $this->belongsTo(Gedung::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pinjamRuangan()
    {
        return $this->belongsTo(PinjamRuangan::class);
    }
}
