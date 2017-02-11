<?php

namespace App\PRS\Validators;

class ValidNotification
{

    public function validate($attribute, $value)
    {
        $validNotification = config('constants.notifications');
        return array_key_exists($value, $validNotification);
    }

    public function message($message, $attribute)
    {
        return "{$attribute} is not a valid notification";
    }

}
