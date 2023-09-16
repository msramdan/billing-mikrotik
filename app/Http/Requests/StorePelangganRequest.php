<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePelangganRequest extends FormRequest
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
            'coverage_area' => 'required|exists:App\Models\AreaCoverage,id',
			'odc' => 'nullable|exists:App\Models\Odc,id',
			'odp' => 'nullable|exists:App\Models\Odp,id',
			'no_port_odp' => 'nullable',
			'no_layanan' => 'required|string|max:12',
			'nama' => 'required|string|max:255',
			'tanggal_daftar' => 'required|date',
			'email' => 'required|email|unique:pelanggans,email',
			'no_wa' => 'required|string|max:15',
			'no_ktp' => 'nullable|string|max:50',
			'photo_ktp' => 'required|image|max:3024',
			'alamat' => 'required|string',
			'password' => 'required|confirmed',
			'ppn' => 'required|in:Yes,No',
			'status_berlangganan' => 'required|in:Aktif,Non Aktif,Menunggu,Tunggakan',
			'paket_layanan' => 'required|exists:App\Models\Package,id',
			'jatuh_tempo' => 'required|numeric',
			'kirim_tagihan_wa' => 'required|in:Yes,No',
			'latitude' => 'required|string|max:50',
			'longitude' => 'required|string|max:50',
			'auto_isolir' => 'required|in:Yes,No',
			'router' => 'nullable|exists:App\Models\Settingmikrotik,id',
			'user_pppoe' => 'nullable|string|max:100',
        ];
    }
}
