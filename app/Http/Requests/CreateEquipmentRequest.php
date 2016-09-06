<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEquipmentRequest extends FormRequest
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
            'kind' => 'required|string|max:40',
            'type' => 'required|string|max:40',
            'brand' => 'required|string|max:40',
            'model' => 'required|string|max:40',
            'capacity' => 'required|numeric',
            'units' => 'required|string|max:10',
            'service_id' => 'required|integer',
        ];
    }
}
