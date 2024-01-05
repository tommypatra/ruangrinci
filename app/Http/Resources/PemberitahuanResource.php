<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PemberitahuanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $waktu_buat = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
        return [
            'id' => $this->id,
            'is_dibaca' => $this->is_dibaca,
            'pengirim' => $this->pengirim,
            'pesan' => $this->pesan,
            'user_id' => $this->user_id,
            'user' => $this->user,
            'judul' => $this->judul,
            'link' => formatNotNull($this->link),
            'pk_id' => $this->pk_id,
            'waktu_lalu' => waktu_lalu($waktu_buat),
            'created_at' => $waktu_buat,
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
