<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisAset extends Model
{
    protected $guarded = ['id'];

    public function dataAset()
    {
        return $this->hasMany(DataAset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
