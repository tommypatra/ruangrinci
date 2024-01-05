<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class DataAsetResource extends JsonResource
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
            'is_aset' => $this->is_aset,
            'status_label' => $this->status_label,
            'bisa_dipinjam' => $this->bisa_dipinjam,
            'kode_barang' => formatNotNull($this->kode_barang),
            'nup' => formatNotNull($this->nup),
            'tgl_masuk' => $this->tgl_masuk,
            'kondisi' => $this->kondisi,
            'deskripsi' => formatNotNull($this->deskripsi),
            'jenis_aset_id' => $this->jenis_aset_id,
            'jenis_aset' => $this->whenLoaded('jenisAset'),
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
