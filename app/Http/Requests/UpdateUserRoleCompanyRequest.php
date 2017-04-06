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
            'name' => 'string|max:25',
            'last_name' => 'string|max:40',
            'email' => 'email',
            'type' => 'integer|between:1,3',
            'cellphone' => 'string|max:20',
            'address' => 'string|max:50',
            'language' => 'string|validLanguage',
            'photo' => 'mimes:jpg,jpeg,png',
            'about' => 'string|max:10000',
        ];
    }
}
