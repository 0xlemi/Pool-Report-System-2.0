<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateUserRoleCompanyRequest extends Request
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
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email',
            'cellphone' => 'required|string|max:20',
            'address' => 'string|max:50',
            'language' => 'required|string|validLanguage',
            'photo' => 'mimes:jpg,jpeg,png',
            'about' => 'string|max:10000',
        ];
    }
}
