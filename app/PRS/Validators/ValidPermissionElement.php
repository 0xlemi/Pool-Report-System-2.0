<?php

namespace App\PRS\Validators;
use App\Permission;

class ValidPermissionElement
{

    public function validate($attribute, $value)
    {
        return (Permission::where('element', '=', $value)->first() != null);
    }

    public function message($message, $attribute)
    {
        return "{$attribute} is not a valid permission element";
    }

}
