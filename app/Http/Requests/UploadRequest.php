<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
            'file' => 'required|file|mimes:heif,jpeg,jpg,png,pdf|max:5000', // Maksimal 2MB
            'detail' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'file' => 'file',
            'detail' => 'detail',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'File harus diunggah.',
            'file.file' => 'Harus memilih file yang valid.',
            'file.mimes' => 'Tipe file harus gambar, PDF, Word, PowerPoint, atau Excel.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 5MB.',
        ];
    }
}
