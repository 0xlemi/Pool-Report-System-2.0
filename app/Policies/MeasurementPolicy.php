<?php

namespace App\Policies;

use App\User;
use App\Measurement;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeasurementPolicy
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
        return $user->selectedUser->hasPermission('measurement', 'view');
    }

    /**
     * Determine whether the user can view the measurement.
     *
     * @param  \App\User  $user
     * @param  \App\Measurement  measurement$
     * @return mixed
     */
    public function view(User $user, Measurement $measurement)
    {
        return $user->selectedUser->hasPermission('measurement', 'view');
    }

    /**
     * Determine whether the user can create measurements.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->selectedUser->hasPermission('measurement', 'create');
    }

    /**
     * Determine whether the user can update the measurement.
     *
     * @param  \App\User  $user
     * @param  \App\Measurement  measurement$
     * @return mixed
     */
    public function update(User $user, Measurement $measurement)
    {
        return $user->selectedUser->hasPermission('measurement', 'update');
    }

    /**
     * Determine whether the user can delete the measurement.
     *
     * @param  \App\User  $user
     * @param  \App\Measurement  measurement$
     * @return mixed
     */
    public function delete(User $user, Measurement $measurement)
    {
        return $user->selectedUser->hasPermission('measurement', 'delete');
    }
}
