<?php

namespace App\PRS\Classes;

use Auth;

class Logged{


    /**
     * Get the user that is logged in
     * @return User
     */
    public static function user()
    {
        $session_user = Auth::user();
        $api_user = Auth::guard('api')->user();

        if(isset($session_user)){
            return $session_user;
        }elseif(isset($api_user)){
            return $api_user;
        }
        return null;
    }

    /**
     * Get the company linked to the current logged in user
     * @return Company
     */
    public static function company()
    {
        return self::user()->selectedUser->company;
    }

}
