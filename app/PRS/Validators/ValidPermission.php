<?php

namespace App\PRS\Validators;

class ValidPermission
{

    public function validate($attribute, $value)
    {
        $validPermission = config('constants.permissions');
        return array_key_exists($value, $validPermission);
    }

    public function message($message, $attribute)
    {
        return "{$attribute} is not a valid permission";
    }

}
