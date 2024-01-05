<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PinjamAsetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        // dd($this->all());
        return [
            'keterangan' => 'required',
            'no_hp' => ['required', 'regex:/^[0-9\-\+\s]+$/'],
            'biaya' => ['required', 'numeric'],
            'peminjam_nama' => 'required',
            'peminjam_lembaga' => 'nullable',
            'verifikator' => 'nullable',
            'is_diterima' => 'nullable',
            'is_pengajuan' => 'nullable',
            'verifikasi_catatan' => 'nullable',
            'waktu_mulai' => 'required|date|date_format:Y-m-d H:i:s',
            'waktu_selesai' => 'nullable|date|date_format:Y-m-d H:i:s',
            'user_id' => 'required',
            'data_aset_id' => 'required',
            'file_upload' => $this->isMethod('put') ? 'nullable|mimes:pdf|max:3000' : 'required|mimes:pdf|max:3000',
        ];
    }

    public function attributes()
    {
        return [
            'verifikator' => 'nama pemeriksa',
            'is_diterima' => 'hasil pemerika',
            'is_pengajuan' => 'status pengajuan',

            'catatan_verifikasi' => 'catatan',
            'keterangan' => 'keterangan',
            'no_hp' => 'nomor hp/whatsapp',
            'biaya' => 'biaya',
            'peminjam_nama' => 'nama',
            'peminjam_lembaga' => 'lembaga',
            'waktu_mulai' => 'waktu mulai',
            'waktu_selesai' => 'waktu selesai',
            'user_id' => 'user',
            'data_aset_id' => 'data aset',
            'file_upload' => 'lampiran',
        ];
    }
}
