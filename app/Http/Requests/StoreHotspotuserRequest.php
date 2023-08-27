<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotspotuserRequest extends FormRequest
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
			'server_hotspot' => 'required|string|max:255',
			'comment' => 'required|string|max:255',
        ];
    }
}
