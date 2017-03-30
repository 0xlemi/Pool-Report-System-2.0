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
        if($user->activeUser->isRole('admin')){
            return true;
        }
    }

    public function profile(User $user)
    {
        if($user->activeUser->isRole('client', 'sup', 'tech')){
            return true;
        }
    }

    public function changeEmail(User $user)
    {
        if($user->activeUser->isRole('client', 'sup', 'tech')){
            return true;
        }
    }

    public function changePassword(User $user)
    {
        if($user->activeUser->isRole('client', 'sup', 'tech')){
            return true;
        }
    }

    public function customization()
    {
        return false;
    }


    public function notifications(User $user)
    {
        if($user->activeUser->isRole('client', 'sup', 'tech')){
            return true;
        }
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
