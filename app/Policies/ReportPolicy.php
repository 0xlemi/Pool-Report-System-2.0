<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Report;

class ReportPolicy
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
            return $user->userable()->admin()->sup_report_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_report_view;
        }
        return false;
    }

    public function view(User $user, Report $report)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_report_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_report_view;
        }
        return false;
    }

    public function create(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_report_create;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_report_create;
        }
        return false;
    }

    public function update(User $user, Report $report)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_report_update;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_report_update;
        }
        return false;
    }

    public function addPhoto(User $user, Report $report)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_report_addPhoto;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_report_addPhoto;
        }
        return false;
    }

    public function removePhoto(User $user, Report $report)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_report_removePhoto;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_report_removePhoto;
        }
        return false;
    }

    public function delete(User $user, Report $report)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_report_delete;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_report_delete;
        }
        return false;
    }


}
