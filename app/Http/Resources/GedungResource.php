<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class GedungResource extends JsonResource
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
            'deskripsi' => formatNotNull($this->deskripsi),
            'luas' => formatNotNull($this->luas),
            'longitude' => formatNotNull($this->longitude),
            'latitude' => formatNotNull($this->latitude),
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
