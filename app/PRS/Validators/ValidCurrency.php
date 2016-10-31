<?php

namespace App\PRS\Validators;

class ValidCurrency
{

    public function validate($attribute, $value)
    {
        $validCurrencies = config('constants.currencies');
        return in_array($value, $validCurrencies);
    }

    public function message($message, $attribute)
    {
        return "The {$attribute} is not a supported currency";
    }

}
