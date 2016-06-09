<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class SupervisorPolicy
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

    public function create($user)
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

    public function show($user)
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

    public function edit($user)
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

    public function destroy($user)
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
