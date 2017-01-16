<?php

namespace App\PRS\Validators;

class ValidTimezone
{

    public function validate($attribute, $value)
    {
        $validTimezones = config('constants.timezones');
        return in_array($value, $validTimezones);
    }

    public function message($message, $attribute)
    {
        return "The {$attribute} is not a supported timezone or incorrect format.";
    }

}
