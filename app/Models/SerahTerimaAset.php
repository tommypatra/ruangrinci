<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerahTerimaAset extends Model
{
    protected $guarded = ['id'];

    public function penggunaAset()
    {
        return $this->belongsTo(PenggunaAset::class);
    }
}
