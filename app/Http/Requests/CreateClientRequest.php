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
        $client_id = NULL;
        if($this->seq_id){
            $client_id = \Auth::user()->clientsBySeqId($this->seq_id)->id;
        }
        return [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            // email uniqueness validation only if they have the same user id
            'email' => 'required|email|unique:clients,email,'
                        .$client_id.',id,user_id,'.\Auth::user()->id,
            'cellphone' => 'required|string|max:20',
            'type' => 'required|numeric|between:1,2',
            'language' => 'required|string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ];
    }
}
