<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class TechnicianPolicy
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
            return $user->userable()->admin()->sup_technician_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_technician_view;
        }
        return false;
    }

    public function create(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_technician_create;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }

    public function update(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_technician_update;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }

    public function delete(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_technician_delete;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }
}
