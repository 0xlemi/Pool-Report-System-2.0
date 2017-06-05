<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\PRS\Classes\Logged;

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
        $company = Logged::company();

        return [
            'service' => 'required|integer|existsBasedOnCompany:services,'.$company->id,
            'person' => 'integer|existsBasedOnCompany:user_role_company,'.$company->id,
            'completed_at' => 'date',
            'readings' => 'array',
            'readings.*' => 'required|validReading:'.$this->service,
            'photo1' => 'required|mimes:jpg,jpeg,png',
            'photo2' => 'required|mimes:jpg,jpeg,png',
            'photo3' => 'required|mimes:jpg,jpeg,png',
        ];
    }

     /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return url('reports/create');
    }
}
