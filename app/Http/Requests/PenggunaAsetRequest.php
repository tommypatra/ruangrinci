<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\DataAset;

class PenggunaAsetRequest extends FormRequest
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
            'keterangan' => 'nullable',
            'tgl_masuk' => 'required|date|date_format:Y-m-d H:i:s',
            'user_id' => 'required',
            'data_aset_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'keterangan' => 'keterangan',
            'tgl_masuk' => 'tanggal masuk',
            'user_id' => 'user',
            'data_aset_id' => 'data aset',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateDataAsetStatus($validator);
        });
    }

    protected function validateDataAsetStatus($validator)
    {
        $dataAsetId = $this->input('data_aset_id');
        $dataAset = DataAset::with(['penggunaAset' => function ($query) {
            $query->orderByDesc('tgl_masuk')->limit(1)->with('serahTerimaAset');
        }])
            ->where('id', $dataAsetId)
            ->first();
        if ($dataAset && $dataAset->penggunaAset->isNotEmpty()) {
            $latestPenggunaAset = $dataAset->penggunaAset->first();
            // dd($latestPenggunaAset);
            if ($latestPenggunaAset->serahTerimaAset->isEmpty()) {
                $validator->errors()->add('data_aset_id', 'Maaf, data aset ini sedang dipinjam.');
            }
        }
    }
}
