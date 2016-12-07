<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class ClientPolicy
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

    /**
     * Administrator has all permissions
     */
    public function before(User $user)
    {
        if($user->isAdministrator()){
            return true;
        }
    }

    // tested (api)
    public function create(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_client_create;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }

    // tested (api)
    public function view(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_client_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_client_view;
        }
        return false;
    }

    // tested (api)
    public function update(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_client_update;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }

    // tested (api)
    public function delete(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_client_delete;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }
}
