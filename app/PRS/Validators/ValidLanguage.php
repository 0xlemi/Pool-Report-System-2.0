<?php

namespace App\PRS\Validators;

class ValidLanguage
{

    public function validate($attribute, $value)
    {
        $validLanguages = config('constants.languages');
        return in_array($value, $validLanguages);
    }

    public function message($message, $attribute)
    {
        return "The {$attribute} is not a supported language or incorrect format.";
    }

}
