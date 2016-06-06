<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index($user)
    {
        if($user->isAdministrator()){
            return true;
        }elseif($user->isClient()){
            return true;
        }elseif($user->isSupervisor()){
            return true;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }
}
