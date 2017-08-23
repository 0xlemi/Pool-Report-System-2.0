<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRoleCompanyRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:30',
            'last_name' => 'required|string|max:60',
            'email' => 'required|email',
            'cellphone' => 'string|max:50',
            'address' => 'string|max:100',
            'language' => 'string|validLanguage',
            'photo' => 'mimes:jpg,jpeg,png',
            'about' => 'string|max:10000',
        ];
    }
}
