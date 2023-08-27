<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotspotuserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
			'password' => 'required|string|max:255',
			'profile' => 'required|string|max:255',
			'uptime' => 'required|string|max:255',
			'bytes_out' => 'required|string|max:255',
			'bytes_in' => 'required|string|max:255',
        ];
    }
}
