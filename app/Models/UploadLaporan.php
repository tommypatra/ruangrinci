<?php

namespace App\Models;

use App\Models\DataAset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UploadLaporan extends Model
{
    protected $guarded = ['id'];

    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
