<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class RuanganResource extends JsonResource
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
            'nama' => $this->nama,
            'is_aktif' => $this->is_aktif,
            'luas' => $this->luas,
            'kapasitas' => $this->kapasitas,
            'lantai' => $this->lantai,
            'deskripsi' => formatNotNull($this->deskripsi),
            'user_id' => $this->user_id,
            'gedung_id' => $this->gedung_id,
            'jumlah_aset' => $this->asetRuangan->count(),
            'asetRuangan' => $this->whenLoaded('asetRuangan'),
            'user' => $this->whenLoaded('user'),
            'gedung' => $this->whenLoaded('gedung'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
