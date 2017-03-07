<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
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
            'chlorine.between' => 'You must choose a valid chlorine value',
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
        $admin = \Auth::user()->admin();
        return [
            'technician' => 'integer|existsBasedOnAdmin:technicians,'.$admin->id,
            'completed_at' => 'date',
            'ph' => 'integer|between:1,5',
            'chlorine' => 'integer|between:1,5',
            'temperature' => 'integer|between:1,5',
            'turbidity' => 'integer|between:1,4',
            'salt' => 'integer|between:1,5',
        ];
    }
}
