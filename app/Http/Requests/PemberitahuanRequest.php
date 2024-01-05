<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PemberitahuanRequest extends FormRequest
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
            'pengirim' => 'nullable',
            'link' => 'nullable',
            'pesan' => 'nullable',
            'is_dibaca' => 'required',
            'pk_id' => 'nullable',
            'judul' => 'nullable',
            'user_id' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'pengirim' => 'nama pengirim',
            'judul' => 'judul',
            'link' => 'link',
            'pk_id' => 'link detail',
            'pesan' => 'isi pemberitahuan',
            'is_dibaca' => 'sudah dibaca',
            'user_id' => 'user',
        ];
    }
}
