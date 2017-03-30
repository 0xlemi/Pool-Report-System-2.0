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
        if($user->activeUser->isRole('admin')){
            return true;
        }
    }

    public function list(User $user)
    {
        return $user->activeUser->hasPermission('report_view');
    }

    public function view(User $user, Report $report)
    {
        return $user->activeUser->hasPermission('report_view');
    }

    public function create(User $user)
    {
        return $user->activeUser->hasPermission('report_create');
    }

    public function update(User $user, Report $report)
    {
        return $user->activeUser->hasPermission('report_update');
    }

    public function addPhoto(User $user, Report $report)
    {
        return $user->activeUser->hasPermission('report_addPhoto');
    }

    public function removePhoto(User $user, Report $report)
    {
        return $user->activeUser->hasPermission('report_removePhoto');
    }

    public function delete(User $user, Report $report)
    {
        return $user->activeUser->hasPermission('report_delete');
    }


}
