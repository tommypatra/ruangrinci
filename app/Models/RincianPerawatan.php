<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianPerawatan extends Model
{
    protected $guarded = ['id'];

    public function perawatan()
    {
        return $this->belongsTo(Perawatan::class);
    }

    public function dataAset()
    {
        return $this->belongsTo(DataAset::class);
    }
}
