<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadPerawatan extends Model
{
    protected $guarded = ['id'];

    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }

    public function perawatan()
    {
        return $this->belongsTo(Perawatan::class);
    }
}
