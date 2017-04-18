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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $company = auth()->user()->selectedUser->company;

        return [
            'person' => 'integer|existsBasedOnCompany:user_role_company,'.$company->id,
            'completed_at' => 'date',
            'readings' => 'array',
            'readings.*' => 'required'
        ];
    }
}
