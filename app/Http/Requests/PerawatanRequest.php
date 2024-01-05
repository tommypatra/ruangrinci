<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerawatanRequest extends FormRequest
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
            'keterangan' => 'required',
            'tempat' => 'required',
            'tgl_masuk' => 'required|date|date_format:Y-m-d H:i:s',
            'tgl_selesai' => 'nullable|date|date_format:Y-m-d H:i:s',
            'user_id' => 'required',
            'laporan_id' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'keterangan' => 'keterangan',
            'tempat' => 'tempat / perusahaan',
            'tgl_masuk' => 'tanggal masuk',
            'tgl_selesai' => 'tanggal keluar',
            'user_id' => 'akun id',
            'laporan_id' => 'laporan id',
        ];
    }
}
