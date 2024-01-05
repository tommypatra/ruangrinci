<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataAsetRequest extends FormRequest
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
            'nama' => 'required',
            'is_aktif' => 'required',
            'is_aset' => 'required',
            'status_label' => 'required',
            'bisa_dipinjam' => 'required',
            'user_id' => 'required',
            'tgl_masuk' => 'required|date|date_format:Y-m-d',
            'kondisi' => 'required',
            'jenis_aset_id' => 'required',
            'deskripsi' => 'nullable',
            'kode_barang' => 'nullable',
            'nup' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'nama' => 'nama aset',
            'is_aktif' => 'status aktif',
            'user_id' => 'user',
            'tgl_masuk' => 'tanggal aset masuk',
            'kondisi' => 'kondisi',
            'jenis_aset_id' => 'jenis aset',
            'deskripsi' => 'deskripsi',
        ];
    }
}
