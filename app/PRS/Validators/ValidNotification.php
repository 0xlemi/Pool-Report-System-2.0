<?php

namespace App\PRS\Validators;

use App\NotificationSetting;

class ValidNotification
{

    public function validate($attribute, $value)
    {
        $num = NotificationSetting::where('name', $value)->count();
        return ($num > 0);
    }

    public function message($message, $attribute)
    {
        return "{$attribute} is not a valid notification";
    }

}
