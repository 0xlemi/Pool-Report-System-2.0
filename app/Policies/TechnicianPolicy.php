<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class TechnicianPolicy
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
            return Auth::user()->userable()->admin()->sup_technician_show;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_technician_show;
        }
        return false;
    }

    public function create($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_technician_create;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_technician_create;
        }
        return false;
    }

    public function show($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_technician_show;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_technician_show;
        }
        return false;
    }

    public function edit($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_technician_edit;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_technician_edit;
        }
        return false;
    }

    public function destroy($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_technician_destroy;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_technician_destroy;
        }
        return false;
    }
}
