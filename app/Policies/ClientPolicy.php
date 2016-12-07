<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class ClientPolicy
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

    public function list(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_client_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_client_view;
        }
        return false;
    }

    public function view(User $user, Client $client)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_client_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_client_view;
        }
        return false;
    }

    public function create(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_client_create;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }

    public function update(User $user, Client $client)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_client_update;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }

    public function delete(User $user, Client $client)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_client_delete;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }
}
