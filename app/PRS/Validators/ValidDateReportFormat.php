<?php

namespace App\PRS\Validators;

class ValidDateReportFormat
{

    public function validate($attribute, $value)
    {
        $d = \DateTime::createFromFormat('Y-m-d', $value);
        return $d && $d->format('Y-m-d') === $value;
    }

    public function message($message, $attribute)
    {
        return "The {$attribute} is not in the correct format (Y-m-d)";
    }

}
