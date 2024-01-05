<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GedungRequest extends FormRequest
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
            'user_id' => 'required',
            'luas' => 'required',
            'longitude' => 'nullable',
            'latitude' => 'nullable',
            'deskripsi' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'is_aktif' => 'status',
            'nama' => 'gedung',
            'user_id' => 'user id',
            'deskripsi' => 'deskripsi',
            'luas' => 'luas',
            'longitude' => 'longitude',
            'latitude' => 'latitude',
        ];
    }
}
