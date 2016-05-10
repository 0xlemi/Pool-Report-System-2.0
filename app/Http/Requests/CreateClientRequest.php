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
        $client = \Auth::user()->clientsBySeqId($this->seq_id);
        return [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email|unique:clients,email,'
                        .$client->id.',id,user_id,'.$client->user_id,
            'cellphone' => 'required|string|max:20',
            'type' => 'required|numeric|between:1,2',
            'language' => 'required|string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ];
    }
}
