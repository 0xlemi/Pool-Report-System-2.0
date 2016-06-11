<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class SupervisorPolicy
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
            return Auth::user()->userable()->admin()->sup_supervisor_index;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_supervisor_index;
        }
        return false;
    }

    public function create($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_supervisor_create;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_supervisor_create;
        }
        return false;
    }

    public function show($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_supervisor_show;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_supervisor_show;
        }
        return false;
    }

    public function edit($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_supervisor_edit;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_supervisor_edit;
        }
        return false;
    }

    public function destroy($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_supervisor_destroy;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_supervisor_destroy;
        }
        return false;
    }
}
