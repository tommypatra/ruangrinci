<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanRequest extends FormRequest
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
        return [
            'keterangan' => 'nullable|required_if:id,null',
            'kode' => 'nullable',
            'verifikasi_catatan' => 'nullable',
            'verifikator' => 'nullable',
            'is_pengajuan' => 'nullable',
            'is_diterima' => 'nullable',
            'user_id' => 'required',
            'data_aset_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'verifikator' => 'verifikator',

            'keterangan' => 'keterangan',
            'kode' => 'kode',
            'verifikasi_catatan' => 'catatan verifikasi',
            'is_pengajuan' => 'status pengajuan',
            'is_diterima' => 'status verifikasi',
            'data_aset_id' => 'data aset',
            'user_id' => 'user id',
        ];
    }
}
