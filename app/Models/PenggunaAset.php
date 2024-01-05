<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaAset extends Model
{
    protected $guarded = ['id'];

    public function dataAset()
    {
        return $this->belongsTo(DataAset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serahTerimaAset()
    {
        return $this->hasMany(SerahTerimaAset::class);
    }
}
