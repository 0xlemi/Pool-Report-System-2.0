<?php

namespace App\PRS\Validators;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Administrator;

class ExistsBasedOnAdmin
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        // Only has support for tables:
        // services
        // supervisors
        // technicians

        $seq_id = $value;
        $table = $parameters[0];
        $admin_id = $parameters[1];

        $admin = Administrator::findOrFail($admin_id);
        if($table == 'services')
        {
            try {
                $admin->serviceBySeqId($seq_id);
            }catch(ModelNotFoundException $e){
                return false;
            }
            return true;
        }
        elseif($table == 'supervisors')
        {
            try {
                $admin->supervisorBySeqId($seq_id);
            }catch(ModelNotFoundException $e){
                return false;
            }
            return true;
        }
        elseif($table == 'technicians')
        {
            try {
                $admin->technicianBySeqId($seq_id);
            }catch(ModelNotFoundException $e){
                return false;
            }
            return true;
        }
        return false;
    }

    public function message($message, $attribute)
    {
        return "{$attribute} with that id, does not exist.";
    }

}
