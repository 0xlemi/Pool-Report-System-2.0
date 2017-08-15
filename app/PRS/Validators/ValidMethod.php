<?php

namespace App\PRS\Validators;

class ValidMethod
{

    public function validate($attribute, $value)
    {
        $validMethods = config('constants.paymentMethods');
        return in_array($value, $validMethods);
    }

    public function message($message, $attribute)
    {
        return "The {$attribute} is not a supported payment method or incorrect format.";
    }

}
