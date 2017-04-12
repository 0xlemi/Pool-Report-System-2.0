<?php

namespace App\PRS\Validators;
use App\NotificationSetting;

class ValidNotificationType
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        $nameKey = $parameters[0];
        // check that the paramenter name is in the other attributes
        if(in_array($nameKey, $validator->attributes())){
            $name = $validator->attributes()[$nameKey];
            return NotificationSetting::where('name', $name)->get()->contains('type', $value);
        }
        return false;
    }

    public function message($message, $attribute)
    {
        return "{$attribute} is not a valid. Not all notifications have all notificationTypes avalible. NotificationTypes can sometimes be: database, mail.";
    }

}
