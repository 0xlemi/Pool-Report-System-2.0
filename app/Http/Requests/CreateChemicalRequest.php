<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateChemicalRequest extends FormRequest
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
            'global_chemical' => 'required|integer|existsBasedOnCompany:global_chemicals,'.$company->id,
            'amount' => 'required|numeric',
        ];
    }
}
