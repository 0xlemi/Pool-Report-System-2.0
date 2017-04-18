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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $company = auth()->user()->selectedUser->company;

        return [
            'service' => 'required|integer|existsBasedOnCompany:services,'.$company->id,
            'person' => 'required|integer|existsBasedOnCompany:user_role_company,'.$company->id,
            'completed_at' => 'required|date',
            'readings' => 'array',
            'readings.*' => 'required|validReading',
            'photo1' => 'required|mimes:jpg,jpeg,png',
            'photo2' => 'required|mimes:jpg,jpeg,png',
            'photo3' => 'required|mimes:jpg,jpeg,png',
        ];
    }
}
