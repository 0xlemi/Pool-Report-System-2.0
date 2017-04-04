<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateClientRequest extends FormRequest
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
            'name' => 'string|max:25',
            'last_name' => 'string|max:40',
            'email' => 'email',
            'cellphone' => 'string|max:20',
            'type' => 'numeric|between:1,2',
            'language' => 'string|max:2',
            'services' => 'array',
            'services.*' => 'required|integer|existsBasedOnCompany:services,'.$company->id,
            'photo' => 'mimes:jpg,jpeg,png',
        ];
    }
}
