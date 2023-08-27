<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingmikrotikRequest extends FormRequest
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
            'identitas_router' => 'required|string|max:255',
            'host' => 'required|string|max:50',
            'port' => 'required|numeric',
            'username' => 'required|string|max:100',
            'password' => 'required|confirmed',
        ];
    }
}
