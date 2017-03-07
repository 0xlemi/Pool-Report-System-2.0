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
        $admin = \Auth::user()->admin();
        try {
            $userable_id  = $admin->clientsBySeqId($this->seq_id)->id;
        }catch(ModelNotFoundException $e){
            abort(422);
        }
        return [
            'name' => 'string|max:25',
            'last_name' => 'string|max:40',
            'email' => 'email|unique:users,email,'.$userable_id.',userable_id',
            'cellphone' => 'string|max:20',
            'type' => 'numeric|between:1,2',
            'language' => 'string|max:2',
            'services' => 'array',
            'services.*' => 'required|integer|existsBasedOnAdmin:services,'.$admin->id,
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ];
    }
}
