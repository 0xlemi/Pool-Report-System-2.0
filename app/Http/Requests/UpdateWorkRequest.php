<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $admin = \Auth::user()->admin();
        return [
            'technician' => 'integer|existsBasedOnAdmin:technicians,'.$admin->id,
            'title' => 'string|max:255',
            'description' => 'string',
            'quantity' => 'numeric',
            'units' => 'string|max:20',
            'cost' => 'numeric|max:10000000',
        ];
    }
}
