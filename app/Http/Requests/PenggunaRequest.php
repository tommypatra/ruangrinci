<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenggunaRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
        ];

        if ($this->isMethod('put')) {
            $rules['password'] = 'nullable|min:8';
            $rules['password_lama'] = 'nullable|min:8';
            $rules['password_ulangi'] = 'nullable|same:password';
        } else {
            $rules['password'] = 'required|min:8';
            $rules['email'] = 'required|email|unique:users,email';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'nama tidak boleh kosong.',
            'password.required' => 'Password harus diketik.',
            'password.min' => 'Password harus memiliki setidaknya 8 karakter.',
            'email.required' => 'email diinput terlebih dahulu.',
            'email.email' => 'format email salah.',
            'email.unique' => 'email tersebut telah terdaftar',
        ];
    }
}
