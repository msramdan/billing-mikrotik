<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOdpRequest extends FormRequest
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
            'kode_odc' => 'required|exists:App\Models\Odc,id',
			'nomor_port_odc' => 'required|numeric',
			'kode_odp' => 'required|string|max:50',
			'wilayah_odp' => 'required|exists:App\Models\AreaCoverage,id',
			'warna_tube_fo' => 'required|string|max:50',
			'nomor_tiang' => 'required|numeric',
			'jumlah_port' => 'required|numeric',
			'document' => 'nullable|image|max:3024',
			'description' => 'required|string',
			'latitude' => 'required|string|max:100',
			'longitude' => 'required|string|max:100',
        ];
    }
}
