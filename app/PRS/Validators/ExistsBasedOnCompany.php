<?php

namespace App\PRS\Validators;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Company;
use App\Administrator;

class ExistsBasedOnCompany
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        // Only has support for tables:
        // services
        // user_role_company

        $seq_id = $value;
        $table = $parameters[0];
        $company_id = $parameters[1];

        $company = Company::findOrFail($company_id);
        if($table == 'services')
        {
            try {
                $company->services()->bySeqId($seq_id);
            }catch(ModelNotFoundException $e){
                return false;
            }
            return true;
        }
        elseif($table == 'user_role_company')
        {
            try {
                $company->userRoleCompanies()->bySeqId($seq_id);
            }catch(ModelNotFoundException $e){
                return false;
            }
            return true;
        }
        elseif($table == 'global_chemicals')
        {
            try {
                $company->globalChemicals()->bySeqId($seq_id);
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
