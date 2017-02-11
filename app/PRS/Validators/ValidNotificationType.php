<?php

namespace App\PRS\Validators;

class ValidNotificationType
{

    public function validate($attribute, $value)
    {
        $validNotification = config('constants.notificationTypes');
        return in_array($value, $validNotification);
    }

    public function message($message, $attribute)
    {
        $types = implode(", ", config('constants.notificationTypes'));
        return "{$attribute} is not a valid. Notification types are: {$types}.";
    }

}
