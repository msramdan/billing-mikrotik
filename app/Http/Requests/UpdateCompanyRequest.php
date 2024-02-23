<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'nama_perusahaan' => 'required|string|max:255',
			'nama_pemilik' => 'required|string|max:255',
			'telepon_perusahaan' => 'nullable|string|max:20',
			'email' => 'nullable|email|unique:companies,email,' . $this->company->id,
			'no_wa' => 'required|string|max:14',
			'alamat' => 'nullable|string',
			'deskripsi_perusahaan' => 'nullable|string',
			'logo' => 'nullable|image|max:3000',
			'favicon' => 'nullable|image|max:3000',
			'url_wa_gateway' => 'required|url|max:255',
			'api_key_wa_gateway' => 'required|string|max:255',
			'is_active' => 'required|in:Yes,No',
			'footer_pesan_wa_tagihan' => 'nullable|string',
			'footer_pesan_wa_pembayaran' => 'nullable|string',
			'url_tripay' => 'required|string|max:255',
			'api_key_tripay' => 'required|string|max:255',
			'kode_merchant' => 'required|string|max:255',
			'private_key' => 'required|string|max:255',
			'paket_id' => 'exists:App\Models\Paket,id',
            'expired' => 'nullable',
        ];
    }
}
