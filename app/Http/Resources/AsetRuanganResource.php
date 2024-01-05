<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class AsetRuanganResource extends JsonResource
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
            'user_id' => $this->user_id,
            'ruangan_id' => $this->ruangan_id,
            'data_aset_id' => $this->data_aset_id,
            'user' => $this->whenLoaded('user'),
            'ruangan' => $this->whenLoaded('ruangan'),
            'data_aset' => $this->whenLoaded('dataAset'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
