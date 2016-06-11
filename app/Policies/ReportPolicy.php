<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class ReportPolicy
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
            return Auth::user()->userable()->admin()->sup_report_index;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_report_index;
        }
        return false;
    }

    public function create($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_report_create;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_report_create;
        }
        return false;
    }

    public function show($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_report_show;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_report_show;
        }
        return false;
    }

    public function edit($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_report_edit;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_report_edit;
        }
        return false;
    }

    public function addPhoto($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_report_addPhoto;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_report_addPhoto;
        }
        return false;
    }

    public function removePhoto($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_report_removePhoto;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_report_removePhoto;
        }
        return false;
    }

    public function destroy($user)
    {
        if($user->isSupervisor()){
            return Auth::user()->userable()->admin()->sup_report_destroy;
        }elseif($user->isTechnician()){
            return Auth::user()->userable()->admin()->tech_report_destroy;
        }
        return false;
    }


}
