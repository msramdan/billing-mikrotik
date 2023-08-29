<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOdcRequest extends FormRequest
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
            'kode_odc' => 'required|string|min:5|max:20',
			'wilayah_odc' => 'required|exists:App\Models\AreaCoverage,id',
			'nomor_port_olt' => 'required|numeric',
			'warna_tube_fo' => 'required|string|max:100',
			'nomor_tiang' => 'required|numeric',
			'document' => 'nullable|image|max:3024',
			'description' => 'required|string',
			'latitude' => 'required|string|max:100',
			'longitude' => 'required|string|max:100',
        ];
    }
}
