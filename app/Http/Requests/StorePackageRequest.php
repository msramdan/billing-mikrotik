<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
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
            'nama_layanan' => 'required|string|max:255',
			'harga' => 'required|numeric',
			'kategori_paket_id' => 'required|exists:App\Models\PackageCategory,id',
			'keterangan' => 'required|string',
            'profile' => 'required|string',
			'is_active' => 'required|in:Yes,No',
        ];
    }
}
