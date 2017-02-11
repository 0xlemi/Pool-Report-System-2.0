<?php

namespace App\PRS\Validators;

class ValidNotificationType
{

    public function validate($attribute, $value)
    {
        $validNotification = config('constants.notificationTypes');
        return array_key_exists($value, $validNotification);
    }

    public function message($message, $attribute)
    {
        $types = implode(", ", array_keys(config('constants.notificationTypes')));
        return "{$attribute} is not a valid. Notification types are: {$types}.";
    }

}
