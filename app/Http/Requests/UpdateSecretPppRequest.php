<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSecretPppRequest extends FormRequest
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
            'username' => 'required|string|max:255',
			'password' => 'required|string|max:255',
			'service' => 'required|string|max:255',
			'profile' => 'required|string|max:255',
			'last_logout' => 'required|string|max:255',
			'komentar' => 'required|string|max:255',
			'status' => 'required|string|max:255',
        ];
    }
}
