<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\PRS\Classes\Logged;

class UpdateWorkRequest extends FormRequest
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
            'technician' => 'integer|existsBasedOnCompany:user_role_company,'.$company->id,
            'title' => 'string|max:255',
            'description' => 'string',
            'quantity' => 'numeric',
            'units' => 'string|max:20',
            'cost' => 'numeric|max:10000000',
        ];
    }
}
