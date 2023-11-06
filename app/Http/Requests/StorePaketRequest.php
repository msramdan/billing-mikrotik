<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaketRequest extends FormRequest
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
            'nama_paket' => 'required|string',
			'jumlah_router' => 'required|numeric',
			'jumlah_pelanggan' => 'required|numeric',
            'jumlah_olt' => 'required|numeric',
        ];
    }
}
