<?php

namespace App\PRS\Traits;

use App\PRS\Classes\Logged;

trait ControllerTrait{


    public function loggedUser()
    {
        return Logged::user();
    }

    public function loggedCompany()
    {
        return Logged::company();
    }

}
