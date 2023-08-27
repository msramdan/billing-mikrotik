<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAreaCoverageRequest extends FormRequest
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
            'kode_area' => 'required|string|max:50',
            'tampilkan_register' => 'required|in:Yes,No',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'keterangan' => 'required|string',
            'radius' => 'required|numeric',
            'latitude' => 'required|string|max:50',
            'longitude' => 'required|string|max:50',
        ];
    }
}
