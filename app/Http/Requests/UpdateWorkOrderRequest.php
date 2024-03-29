<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\PRS\Classes\Logged;

class UpdateWorkOrderRequest extends FormRequest
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
            'title' => 'string|max:255',
            'description' => 'string',
            'service' => 'integer|existsBasedOnCompany:services,'.$company->id,
            'person' => 'integer|existsBasedOnCompany:user_role_company,'.$company->id,
            'start' => 'date',
            'photo' => 'mimes:jpg,jpeg,png',
        ];
    }
}
