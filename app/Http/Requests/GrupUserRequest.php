<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupUserRequest extends FormRequest
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
            'grup_id' => 'required',
            'user_id' => 'required',
            'is_aktif' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'is_aktif.required' => 'status dibutuhkan',
            'grup_id.required' => 'grup dibutuhkan',
            'user_id.required' => 'user id dibutuhkan',
        ];
    }
}
