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
        if($user->selectedUser->isRole('admin')){
            return true;
        }
    }

    public function list(User $user)
    {
        return $user->selectedUser->hasPermission('equipment', 'view');
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
        if($user->selectedUser->isRole('client')){
            // return $user->userable()->hasEquipment($equipment->id);
            return true; // temporary
        }
        return $user->selectedUser->hasPermission('equipment', 'view');
    }

    /**
     * Determine whether the user can create chemiEquipments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->selectedUser->hasPermission('equipment', 'create');
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
        return $user->selectedUser->hasPermission('equipment', 'update');
    }

    public function addPhoto(User $user, Equipment $equipment)
    {
        return $user->selectedUser->hasPermission('equipment', 'addPhoto');
    }

    public function removePhoto(User $user, Equipment $equipment)
    {
        return $user->selectedUser->hasPermission('equipment', 'removePhoto');
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
        return $user->selectedUser->hasPermission('equipment', 'delete');
    }
}
