<?php

namespace App\Policies;

use App\User;
use App\GlobalMeasurement;
use Illuminate\Auth\Access\HandlesAuthorization;

class GlobalMeasurementPolicy
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
        return $user->selectedUser->hasPermission('globalmeasurement', 'view');
    }

    /**
     * Determine whether the user can view the globalmeasurement.
     *
     * @param  \App\User  $user
     * @param  \App\GlobalMeasurement   globalmeasurement$
     * @return mixed
     */
    public function view(User $user, GlobalMeasurement  $globalMeasurement)
    {
        return $user->selectedUser->hasPermission('globalmeasurement', 'view');
    }

    /**
     * Determine whether the user can create globalmeasurements.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->selectedUser->hasPermission('globalmeasurement', 'create');
    }

    /**
     * Determine whether the user can update the globalmeasurement.
     *
     * @param  \App\User  $user
     * @param  \App\GlobalMeasurement   globalmeasurement$
     * @return mixed
     */
    public function update(User $user, GlobalMeasurement  $globalMeasurement)
    {
        return $user->selectedUser->hasPermission('globalmeasurement', 'update');
    }

    /**
     * Determine whether the user can delete the globalmeasurement.
     *
     * @param  \App\User  $user
     * @param  \App\GlobalMeasurement   globalmeasurement$
     * @return mixed
     */
    public function delete(User $user, GlobalMeasurement  $globalMeasurement)
    {
        return $user->selectedUser->hasPermission('globalmeasurement', 'delete');
    }

}
