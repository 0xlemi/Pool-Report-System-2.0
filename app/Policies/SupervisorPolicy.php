<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class SupervisorPolicy
{
    use HandlesAuthorization;

    /**
     * Administrator has all permissions
     */
    public function before(User $user)
    {
        if($user->isAdministrator()){
            return true;
        }
    }

    public function view(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_supervisor_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_supervisor_view;
        }
        return false;
    }

    public function create(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_supervisor_create;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }

    public function update(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_supervisor_update;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }

    public function delete(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_supervisor_delete;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }
}
