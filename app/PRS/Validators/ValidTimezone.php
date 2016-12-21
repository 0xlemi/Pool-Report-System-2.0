<?php

namespace App\PRS\Validators;

class ValidTimezone
{

    public function validate($attribute, $value)
    {
        $validCurrencies = config('constants.timezones');
        return in_array($value, $validCurrencies);
    }

    public function message($message, $attribute)
    {
        return "The {$attribute} is not a supported timezone or incorrect format.";
    }

}
