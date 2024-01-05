<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class PenggunaAsetResource extends JsonResource
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
            'tgl_masuk' => $this->tgl_masuk,
            'keterangan' => $this->keterangan,
            'user_id' => $this->user_id,
            'aset_aset_id' => $this->data_aset_id,
            'serah_terima_aset_id' => $this->serah_terima_aset_id,
            'user' => $this->whenLoaded('user'),
            'serah_terima_aset' => $this->whenLoaded('serahTerimaAset'),
            'data_aset' => $this->whenLoaded('dataAset'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
