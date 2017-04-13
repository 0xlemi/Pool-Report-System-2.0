<?php

namespace App\PRS\Validators;
use App\Permission;

class ValidPermission
{

    public function validate($attribute, $value)
    {
        return (Permission::find($value) != null);
    }

    public function message($message, $attribute)
    {
        return "{$attribute} is not a valid permission";
    }

}
