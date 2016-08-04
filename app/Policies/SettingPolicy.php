<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

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
    public function before($type)
    {
        if($type->isAdministrator()){
            return true;
        }
    }

    public function account($type)
    {
        if($type->isAdministrator() || $type->isSupervisor() || $type->isTechnician()){
            return true;
        }
        return false;
    }

    public function changeEmail($type)
    {
        if($type->isSupervisor() || $type->isTechnician()){
            return true;
        }
        return false;
    }

    public function changePassword($type)
    {
        if($type->isSupervisor() || $type->isTechnician()){
            return true;
        }
        return false;
    }

    public function company($type)
    {
        return false;
    }


    public function email($type)
    {
        if($type->isSupervisor() || $type->isTechnician()){
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
