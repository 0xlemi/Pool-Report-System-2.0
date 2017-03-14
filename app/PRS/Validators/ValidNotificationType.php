<?php

namespace App\PRS\Validators;

class ValidNotificationType
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        $notifications = config('constants.notifications');

        // check that the paramenter name is in the other attributes
        if(in_array($parameters[0], $validator->attributes())){
            $name = $validator->attributes()[$parameters[0]];
            // first check that the notification name exists
            if(!array_key_exists($name, (array) $notifications)){
                return false;
            }
            // then check that that notification name has the desired type
            $validTypes = $notifications->$name->types;
            return in_array($value, (array) $validTypes );
        };
        $validNotification = config('constants.notificationTypes');
        return array_key_exists($value, (array) $validNotification);
    }

    public function message($message, $attribute)
    {
        $types = implode(", ", array_keys((array)config('constants.notificationTypes')));
        return "{$attribute} is not a valid. Not all notifications have all notificationTypes avalible. NotificationTypes can be: {$types}.";
    }

}
