<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SerahTerimaAsetRequest extends FormRequest
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
            'keterangan' => 'nullable',
            'tgl_kembali' => 'required|date|date_format:Y-m-d H:i:s',
            'kondisi' => 'required',
            'pengguna_aset_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'keterangan' => 'keterangan',
            'tgl_kembali' => 'tanggal kembali',
            'kondisi' => 'kondisi',
            'pengguna_aset_id' => 'aset yang digunakan',
        ];
    }
}
