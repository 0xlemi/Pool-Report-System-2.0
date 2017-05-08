<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\PRS\Classes\Logged;

class CreateWorkOrderRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'service' => 'required|integer|existsBasedOnCompany:services,'.$company->id,
            'person' => 'required|integer|existsBasedOnCompany:user_role_company,'.$company->id,
            'start' => 'required|date',
            'price' => 'required|numeric|max:10000000',
            'currency' => 'required|string|validCurrency',
            'photo' => 'mimes:jpg,jpeg,png',
        ];
    }
}
