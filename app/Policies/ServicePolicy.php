<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class ServicePolicy
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
    public function before($user)
    {
        if($user->isAdministrator()){
            return true;
        }
    }


    public function index($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_service_index;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_service_index;
        }
        return false;
    }

    public function create($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_service_create;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_service_create;
        }
        return false;
    }

    public function show($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_service_show;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_service_show;
        }
        return false;
    }

    public function edit($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_service_edit;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_service_edit;
        }
        return false;
    }

    public function destroy($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_service_destroy;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_service_destroy;
        }
        return false;
    }
}
