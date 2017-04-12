<?php

namespace App\PRS\Validators;

use DB;

class ValidNotification
{

    public function validate($attribute, $value)
    {
        $num = DB::table('notification_settings')->where('name', $value)->count();
        return ($num > 0);
    }

    public function message($message, $attribute)
    {
        return "{$attribute} is not a valid notification";
    }

}
