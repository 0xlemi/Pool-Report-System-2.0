<?php

namespace App\PRS\Traits;

use App\PRS\Classes\Logged;

trait ControllerTrait{

    public function loggedUserAdministrator()
    {
        return (new Logged)->admin();
    }

    public function getUser()
    {
        return (new Logged)->user();
    }

}
