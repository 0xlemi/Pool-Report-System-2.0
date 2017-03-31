<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTechnicianRequest extends FormRequest
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
            $userable_id  = $admin->technicianBySeqId($this->seq_id)->id;
        }catch(ModelNotFoundException $e){
            abort(422);
        }
        return [
            'name' => 'string|max:25',
            'last_name' => 'string|max:40',
            'supervisor' => 'integer|existsBasedOnCompany:supervisors,'.$admin->id,
            'username' => 'alpha_dash|between:4,25|unique:users,email,'.$userable_id.',userable_id',
            'cellphone' => 'string|max:20',
            'address'   => 'string|max:100',
            'language' => 'string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ];
    }
}
