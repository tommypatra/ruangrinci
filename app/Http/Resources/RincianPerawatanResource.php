<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RincianPerawatanResource extends JsonResource
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
            'biaya' => $this->biaya,
            'keterangan' => $this->keterangan,
            'perawatan_id' => $this->perawatan_id,
            'data_aset_id' => $this->data_aset_id,
            'perawatan' => $this->whenLoaded('perawatan'),
            'data_aset' => $this->whenLoaded('dataAset'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
