<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceContractRequest extends FormRequest
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
            'start' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'amount' => 'required|numeric|max:10000000',
            'currency' => 'required|string|size:3|validCurrency',
            'service_days' => 'required|array|size:7',
            'service_days.monday' => 'required|boolean',
            'service_days.tuesday' => 'required|boolean',
            'service_days.wednesday' => 'required|boolean',
            'service_days.thursday' => 'required|boolean',
            'service_days.friday' => 'required|boolean',
            'service_days.saturday' => 'required|boolean',
            'service_days.sunday' => 'required|boolean',
        ];
    }
}
