<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RuanganRequest extends FormRequest
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
            'luas' => 'required|integer',
            'kapasitas' => 'required|integer',
            'lantai' => 'required|integer',
            'user_id' => 'required',
            'gedung_id' => 'required',
            'deskripsi' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'is_aktif' => 'status',
            'nama' => 'gedung',
            'user_id' => 'user',
            'gedung_id' => 'gedung',
            'luas' => 'luas',
            'kapasitas' => 'kapasitas',
            'lantai' => 'lantai',
            'deskripsi' => 'deskripsi',
        ];
    }

    public function messages()
    {
        return [
            'kapasitas.integer' => 'Kapasitas harus berupa angka',
        ];
    }
}
