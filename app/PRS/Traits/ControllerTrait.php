<?php

namespace App\PRS\Traits;

use Auth;

trait ControllerTrait{

    public function loggedUserAdministrator()
    {
        $user = $this->getUser();
        if(isset($user)){
            return $user->admin();
        }
        return null;
    }

    public function getUser()
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

    

}
