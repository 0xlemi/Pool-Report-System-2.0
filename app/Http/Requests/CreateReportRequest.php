<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateReportRequest extends Request
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
            'technician.min' => 'You must choose a technician',
            'ph.between' => 'You must choose a valid ph value',
            'clorine.between' => 'You must choose a valid clorine value',
            'temperature.between' => 'You must choose a valid temperature value',
            'turbidity.between' => 'You must choose a valid turbidity value',
            'salt.between' => 'You must choose a valid salt value',
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
            'service' => 'required|integer|min:1',
            'technician' => 'required|integer|min:1',
            'completed_at' => 'required|date',
            'ph' => 'required|integer|between:1,5',
            'clorine' => 'required|integer|between:1,5',
            'temperature' => 'required|integer|between:1,5',
            'turbidity' => 'required|integer|between:1,4',
            'salt' => 'required|integer|between:1,5',
            'photo1' => 'required|mimes:jpg,jpeg,png',
            'photo2' => 'required|mimes:jpg,jpeg,png',
            'photo3' => 'required|mimes:jpg,jpeg,png',
        ];
    }
}
