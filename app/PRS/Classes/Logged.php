<?php

namespace App\PRS\Classes;

use Auth;

class Logged{


    /**
     * Get the user that is logged in
     * @return User
     */
    public function user()
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
     * Get the administrator linked to the current logged in user
     * @return Administrator
     */
    public function admin()
    {
        return $this->user()->admin();
    }

}
