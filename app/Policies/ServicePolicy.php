<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Service;

class ServicePolicy
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
        return $user->activeUser->hasPermission('service_view');
    }

    public function view(User $user, Service $service)
    {
        return $user->activeUser->hasPermission('service_view');
    }

    public function create(User $user)
    {
        return $user->activeUser->hasPermission('service_create');
    }

    public function update(User $user, Service $service)
    {
        return $user->activeUser->hasPermission('service_update');
    }

    public function delete(User $user, Service $service)
    {
        return $user->activeUser->hasPermission('service_delete');
    }
}
