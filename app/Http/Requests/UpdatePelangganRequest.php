<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePelangganRequest extends FormRequest
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
			'odc' => 'required|exists:App\Models\Odc,id',
			'odp' => 'required|exists:App\Models\Odp,id',
			'no_port_odp' => 'required',
			'no_layanan' => 'required|string|max:12',
			'nama' => 'required|string|max:255',
			'tanggal_daftar' => 'required|date',
			'email' => 'required|email|unique:pelanggans,email,' . $this->pelanggan->id,
			'no_wa' => 'required|string|max:15',
			'no_ktp' => 'required|string|max:50',
			'photo_ktp' => 'nullable|image|max:3024',
			'alamat' => 'required|string',
			'password' => 'nullable|confirmed',
			'ppn' => 'required|in:Yes,No',
			'status_berlangganan' => 'required|in:Aktif,Non Aktif,Menungu',
			'paket_layanan' => 'required|exists:App\Models\Package,id',
			'jatuh_tempo' => 'required|numeric',
			'kirim_tagihan_wa' => 'required|in:Yes,No',
			'latitude' => 'required|string|max:50',
			'longitude' => 'required|string|max:50',
			'auto_isolir' => 'nullable|in:Yes,No',
			'tempo_isolir' => 'nullable|numeric',
			'router' => 'required|exists:App\Models\Settingmikrotik,id',
			'user_pppoe' => 'required|string|max:100',
        ];
    }
}
