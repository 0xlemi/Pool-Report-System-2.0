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
        if($user->isAdministrator()){
            return true;
        }
    }

    public function list(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_equipment_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_equipment_view;
        }elseif($user->isClient()){
            return true;
        }
        return false;
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
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_equipment_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_equipment_view;
        }elseif($user->isClient()){
            return true;
        }
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
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_equipment_create;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_equipment_create;
        }
        return false;
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
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_equipment_update;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_equipment_update;
        }
        return false;
    }

    public function addPhoto(User $user, Equipment $equipment)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_equipment_addPhoto;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_equipment_addPhoto;
        }
        return false;
    }

    public function removePhoto(User $user, Equipment $equipment)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_equipment_removePhoto;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_equipment_removePhoto;
        }
        return false;
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
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_equipment_delete;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_equipment_delete;
        }
        return false;
    }
}
