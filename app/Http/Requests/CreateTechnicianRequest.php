<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateTechnicianRequest extends Request
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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'supervisor.min' => 'You must choose a supervisor',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        // get the supervisor id if is upadate request if not null
        $userable_id = NULL;
        if($this->seq_id){
            $userable_id = \Auth::user()->userable()->technicianBySeqId($this->seq_id)->id;
        }

        return [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'supervisor' => 'required|integer|min:1',
            'username' => 'required|alpha_dash|between:4,25|unique:users,'.$userable_id.',userable_id',
            'password' => 'required|string|between:6,40',
            'cellphone' => 'required|string|max:20',
            'address'   => 'string|max:100',
            'language' => 'required|string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ];
    }
}
