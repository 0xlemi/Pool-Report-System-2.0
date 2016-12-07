<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class ServicePolicy
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
            return $user->userable()->admin()->sup_service_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_service_view;
        }
        return false;
    }

    public function create(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_service_create;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_service_create;
        }
        return false;
    }

    public function update(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_service_update;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_service_update;
        }
        return false;
    }

    public function delete(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_service_delete;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }
}
