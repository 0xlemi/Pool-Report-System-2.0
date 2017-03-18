<?php

namespace App\PRS\Validators;

class ValidConstant
{

    public function validate($attribute, $value)
    {
        $validCurrencies = config('constants.constants');
        return in_array($value, $validCurrencies);
    }

    public function message($message, $attribute)
    {
        $constants = implode(", ", config('constants.constants'));
        return "The {$attribute} doesn't match any constant. Valid constants are [{$constants}]";
    }

}
