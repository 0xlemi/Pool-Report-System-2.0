<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateServiceRequest extends Request
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
            'name' => 'required|string|max:20',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'address_line' => 'required|string|max:50',
            'city' => 'required|string|max:30',
            'state' => 'required|string|max:30',
            'postal_code' => 'required|string|max:15',
            'country' => 'required|string|max:2',
            'comments' => 'string|max:10000',
            'photo' => 'mimes:jpg,jpeg,png',
        ];
    }
}
