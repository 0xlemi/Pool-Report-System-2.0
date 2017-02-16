<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class SettingPolicy
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

    public function profile(User $user)
    {
        if($user->isSupervisor() || $user->isTechnician() || $user->isClient()){
            return true;
        }
        return false;
    }

    public function changeEmail(User $user)
    {
        if($user->isSupervisor() || $user->isTechnician() || $user->isClient()){
            return true;
        }
        return false;
    }

    public function changePassword(User $user)
    {
        if($user->isSupervisor() || $user->isTechnician() || $user->isClient()){
            return true;
        }
        return false;
    }

    public function customization()
    {
        return false;
    }


    public function notifications(User $user)
    {
        if($user->isSupervisor() || $user->isTechnician() || $user->isClient()){
            return true;
        }
        return false;
    }

    public function billing()
    {
        return false;
    }

    public function permissions()
    {
        return false;
    }

}
