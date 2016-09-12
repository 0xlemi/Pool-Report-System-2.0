<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkRequest extends FormRequest
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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'technician.min' => 'You must choose a technician',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|numeric',
            'units' => 'required|string|max:20',
            'cost' => 'required|numeric|max:10000000',
            'work_order_id'=> 'required|integer|min:1',
            'technician_id' => 'required|integer|min:1',
        ];
    }
}
