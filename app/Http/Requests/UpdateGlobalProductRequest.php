<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGlobalProductRequest extends FormRequest
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
            'name' => 'string|max:255',
            'brand' => 'string|max:255',
            'type' => 'string|max:255',
            'units' => 'string|max:255',
            'unit_price' => 'numeric',
            'unit_currency' => 'string|size:3|validCurrency',
        ];
    }
}
