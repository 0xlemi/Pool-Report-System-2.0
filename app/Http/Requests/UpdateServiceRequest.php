<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'name' => 'string|max:20',
            'latitude' => 'numeric|between:-90,90',
            'longitude' => 'numeric|between:-180,180',
            'address_line' => 'string|max:50',
            'city' => 'string|max:30',
            'state' => 'string|max:30',
            'postal_code' => 'string|max:15',
            'country' => 'string|max:2',
            'comments' => 'string|max:10000',
            'photo' => 'mimes:jpg,jpeg,png',
        ];
    }
}
