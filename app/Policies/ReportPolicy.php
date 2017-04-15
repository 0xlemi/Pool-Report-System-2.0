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
        if($user->selectedUser->isRole('admin')){
            return true;
        }
    }

    public function list(User $user)
    {
        return $user->selectedUser->hasPermission('report', 'view');
    }

    public function view(User $user, Report $report)
    {
        return $user->selectedUser->hasPermission('report', 'view');
    }

    public function create(User $user)
    {
        return $user->selectedUser->hasPermission('report', 'create');
    }

    public function update(User $user, Report $report)
    {
        return $user->selectedUser->hasPermission('report', 'update');
    }

    public function addPhoto(User $user, Report $report)
    {
        return $user->selectedUser->hasPermission('report', 'addPhoto');
    }

    public function removePhoto(User $user, Report $report)
    {
        return $user->selectedUser->hasPermission('report', 'removePhoto');
    }

    public function delete(User $user, Report $report)
    {
        return $user->selectedUser->hasPermission('report', 'delete');
    }


}
