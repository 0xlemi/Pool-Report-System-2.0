<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateSupervisorRequest extends Request
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
        // get the supervisor id if is upadate request if not null
        $supervisor_id = NULL;
        if($this->seq_id){
            $supervisor_id = \Auth::user()->supervisorBySeqId($this->seq_id)->id;
        }

        return [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email|unique:supervisors,email,'.$supervisor_id.',id,user_id,'.\Auth::user()->id,
            'password' => 'required|string|between:6,40',
            'cellphone' => 'required|string|max:20',
            'address'   => 'string|max:100',
            'language' => 'required|string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ];
    }
}
