<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest
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
            'start' => 'date',
            'start_time' => 'date_format:H:i',
            'end_time' => 'date_format:H:i|after:start_time',
            'amount' => 'numeric|max:10000000',
            'currency' => 'string|size:3|validCurrency',
            'service_days' => 'array|size:7',
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
