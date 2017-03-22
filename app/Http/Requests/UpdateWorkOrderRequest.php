<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $admin = \Auth::user()->admin();
        return [
            'title' => 'string|max:255',
            'description' => 'string',
            'service' => 'integer|existsBasedOnAdmin:services,'.$admin->id,
            'supervisor' => 'integer|existsBasedOnAdmin:supervisors,'.$admin->id,
            'start' => 'date',
            'photo' => 'mimes:jpg,jpeg,png',
        ];
    }
}
