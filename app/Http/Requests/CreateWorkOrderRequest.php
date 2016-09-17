<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkOrderRequest extends FormRequest
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
            'service.min' => 'You must choose a service',
            'supervisor.min' => 'You must choose a supervisor',
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
            'service' => 'required|integer|min:1',
            'supervisor' => 'required|integer|min:1',
            'start' => 'required|date',
            'price' => 'required|numeric|max:10000000',
            'currency' => 'required|string|size:3',
            'photo' => 'mimes:jpg,jpeg,png',
        ];
    }
}
