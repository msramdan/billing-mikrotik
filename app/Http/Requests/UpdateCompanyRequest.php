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
            'telepon_perusahaan' => 'required|max:15',
            'no_wa' => 'required|max:15',
            'email' => 'required|email|unique:companies,email,' . $this->company->id,
            'alamat' => 'required|string',
            'deskripsi_perusahaan' => 'required|string',
            'favicon' => 'image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048|dimensions:width=512,height=512',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048|dimensions:width=660,height=220',
        ];
    }
}
