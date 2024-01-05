<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PerawatanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tempat' => $this->tempat,
            'keterangan' => $this->keterangan,
            'tgl_masuk' => $this->tgl_masuk,
            'tgl_selesai' => $this->tgl_selesai,
            'user_id' => $this->user_id,
            'user' => $this->user,
            'laporan_id' => $this->laporan_id,
            'laporan' => $this->laporan,
            'upload_perawatan' => $this->uploadPerawatan,
            'jumlah_upload' => count($this->uploadPerawatan),
            'rincian_perawatan' => $this->rincianPerawatan,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
