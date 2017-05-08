<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\PRS\Classes\Logged;

class CreateMeasurementRequest extends FormRequest
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
        $company = Logged::company();

        return [
            'global_measurement' => 'required|integer|existsBasedOnCompany:global_measurements,'.$company->id,
        ];
    }
}
