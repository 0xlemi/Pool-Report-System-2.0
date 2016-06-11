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
    public function before($user)
    {
        if($user->isAdministrator()){
            return true;
        }
    }

    public function index($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_client_index;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_client_index;
        }
        return false;
    }

    public function create($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_client_create;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_client_create;
        }
        return false;
    }

    public function show($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_client_show;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_client_show;
        }
        return false;
    }

    public function edit($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_client_edit;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_client_edit;
        }
        return false;
    }

    public function destroy($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_client_destroy;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_client_destroy;
        }
        return false;
    }
}
