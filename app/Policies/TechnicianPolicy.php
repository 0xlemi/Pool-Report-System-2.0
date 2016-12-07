<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class TechnicianPolicy
{
    use HandlesAuthorization;

    /**
     * Administrator has all permissions
     */
    public function before($user)
    {
        if($user->isAdministrator()){
            return true;
        }
    }

    public function view($user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_technician_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_technician_view;
        }
        return false;
    }

    public function create($user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_technician_create;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }

    public function update($user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_technician_update;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }

    public function delete($user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_technician_delete;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }
}
