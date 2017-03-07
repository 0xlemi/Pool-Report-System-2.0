<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateClientRequest extends Request
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
        // get the client id if is upadate request if not null
        $userable_id = NULL;
        if($this->seq_id){
            $userable_id  = \Auth::user()->admin()->clientsBySeqId($this->seq_id)->id;
        }
        return [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email|unique:users,email,'.$userable_id.',userable_id',
            'cellphone' => 'required|string|max:20',
            'type' => 'required|numeric|between:1,2',
            'language' => 'required|string|max:2',
            'services' => 'array',
            'services.*' => 'required|integer|existsBasedOnAdmin:services,'.$admin->id,
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ];
    }
}
