<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilRequest extends FormRequest
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
            'alamat' => 'required',
            'hp' => 'required',
            'jenis_kelamin' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'alamat' => 'alamat',
            'hp' => 'hp',
            'jenis_kelamin' => 'jenis kelamin',
        ];
    }
}
