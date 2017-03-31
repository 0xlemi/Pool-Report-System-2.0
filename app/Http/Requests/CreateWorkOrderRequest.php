<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $admin = \Auth::user()->admin();
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'service' => 'required|integer|existsBasedOnCompany:services,'.$admin->id,
            'supervisor' => 'required|integer|existsBasedOnCompany:supervisors,'.$admin->id,
            'start' => 'required|date',
            'price' => 'required|numeric|max:10000000',
            'currency' => 'required|string|validCurrency',
            'photo' => 'mimes:jpg,jpeg,png',
        ];
    }
}
