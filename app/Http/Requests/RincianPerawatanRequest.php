<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RincianPerawatanRequest extends FormRequest
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
            'user_id' => 'required',
            'perawatan_id' => 'required',
            'data_aset_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'user',
            'perawatan_id' => 'ruangan',
            'data_aset_id' => 'data aset',
        ];
    }
}
