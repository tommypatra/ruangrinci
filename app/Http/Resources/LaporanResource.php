<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class LaporanResource extends JsonResource
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
            'is_pengajuan' => $this->is_pengajuan,
            'kode' => $this->kode,
            'qrcode' => $this->qrcode,
            'verifikasi_catatan' => formatNotNull($this->verifikasi_catatan),
            'is_diterima' => $this->is_diterima,
            'keterangan' => $this->keterangan,
            'verifikator' => formatNotNull($this->verifikator),
            'user_id' => $this->user_id,
            'data_aset_id' => $this->data_aset_id,
            'data_aset' => $this->dataAset,
            'upload_laporan' => $this->uploadLaporan,
            'jumlah_upload' => count($this->uploadLaporan),
            'user' => $this->user,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
