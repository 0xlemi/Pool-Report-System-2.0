<?php

namespace App\PRS\Validators;
use App\Permission;

class ValidPermissionAction
{

    public function validate($attribute, $value)
    {
        return (Permission::where('action', '=', $value)->first() != null);
    }

    public function message($message, $attribute)
    {
        return "{$attribute} is not a valid permission action";
    }

}
