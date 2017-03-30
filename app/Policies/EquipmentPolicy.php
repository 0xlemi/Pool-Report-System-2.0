<?php

namespace App\Policies;

use App\User;
use App\Equipment;
use Illuminate\Auth\Access\HandlesAuthorization;

class EquipmentPolicy
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
        return $user->activeUser->hasPermission('equipment_view');
    }

    /**
     * Determine whether the user can view the Equipment.
     *
     * @param  \App\User  $user
     * @param  \App\Equipment  $equipment
     * @return mixed
     */
    public function view(User $user, Equipment $equipment)
    {
        if($user->activeUser->isRole('client')){
            // return $user->userable()->hasEquipment($equipment->id);
            return false; // temporary
        }
        return $user->activeUser->hasPermission('equipment_view');
        return false;
    }

    /**
     * Determine whether the user can create chemiEquipments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->activeUser->hasPermission('equipment_create');
    }

    /**
     * Determine whether the user can update the Equipment.
     *
     * @param  \App\User  $user
     * @param  \App\Equipment  $equipment
     * @return mixed
     */
    public function update(User $user, Equipment $equipment)
    {
        return $user->activeUser->hasPermission('equipment_update');
    }

    public function addPhoto(User $user, Equipment $equipment)
    {
        return $user->activeUser->hasPermission('equipment_addPhoto');
    }

    public function removePhoto(User $user, Equipment $equipment)
    {
        return $user->activeUser->hasPermission('equipment_removePhoto');
    }

    /**
     * Determine whether the user can delete the Equipment.
     *
     * @param  \App\User  $user
     * @param  \App\Equipment  $equipment
     * @return mixed
     */
    public function delete(User $user, Equipment $equipment)
    {
        return $user->activeUser->hasPermission('equipment_delete');
    }
}
