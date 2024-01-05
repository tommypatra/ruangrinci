<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PinjamAsetResource extends JsonResource
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
            'peminjam_nama' => $this->peminjam_nama,
            'peminjam_lembaga' => formatNotNull($this->peminjam_lembaga),
            'no_hp' => $this->no_hp,
            'waktu_mulai' => $this->waktu_mulai,
            'waktu_selesai' => $this->waktu_selesai,
            'verifikator' => formatNotNull($this->verifikator),
            'is_diterima' => $this->is_diterima,
            'is_pengajuan' => $this->is_pengajuan,
            'verifikasi_catatan' => formatNotNull($this->verifikasi_catatan),
            'user_id' => $this->user_id,
            'user' => $this->user,
            'file_upload' => $this->file_upload,
            'data_aset_id' => $this->laporan_id,
            'data_aset' => $this->dataAset,
            'jumlah_waktu' => waktu_lalu($this->waktu_mulai, $this->waktu_selesai),
            'waktu_mulai2' => Carbon::parse($this->waktu_mulai)->format('Y-m-d\Th:i:s'),
            'waktu_selesai2' => Carbon::parse($this->waktu_selesai)->format('Y-m-d\Th:i:s'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
