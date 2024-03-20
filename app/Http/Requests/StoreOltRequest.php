<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOltRequest extends FormRequest
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
            'name' => 'required|string',
			'type' => 'required|in:Zte,Huawei',
			'host' => 'required|string',
            'telnet_port' => 'required',
			'telnet_username' => 'required|string',
			'telnet_password' => 'required|string',
            'snmp_port' => 'required',
            'ro_community' => 'required|string',
        ];
    }
}
