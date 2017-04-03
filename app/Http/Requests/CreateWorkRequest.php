<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkRequest extends FormRequest
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
            'technician' => 'required|integer|existsBasedOnCompany:user_role_company,'.$company->id,
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|numeric',
            'units' => 'required|string|max:20',
            'cost' => 'required|numeric|max:10000000',
        ];
    }
}
