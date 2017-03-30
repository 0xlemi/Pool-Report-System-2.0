<?php

namespace App\PRS\Traits;

use App\PRS\Classes\Logged;

trait ControllerTrait{


    public function loggedUser()
    {
        return (new Logged)->user()->activeUser;
    }

    public function loggedCompany()
    {
        return (new Logged)->company();
    }

}
