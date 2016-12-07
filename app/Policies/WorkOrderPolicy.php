<?php

namespace App\Policies;

use App\User;
use App\WorkOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkOrderPolicy
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
            return $user->userable()->admin()->sup_workorder_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_workorder_view;
        }
        return false;
    }

    /**
     * Determine whether the user can view the WorkOrder.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrder  $WorkOrder
     * @return mixed
     */
    public function view(User $user, WorkOrder $WorkOrder)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_workorder_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_workorder_view;
        }
        return false;
    }

    /**
     * Determine whether the user can create WorkOrders.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_workorder_create;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_workorder_create;
        }
        return false;
    }

    /**
     * Determine whether the user can update the WorkOrder.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrder  $WorkOrder
     * @return mixed
     */
    public function update(User $user, WorkOrder $WorkOrder)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_workorder_update;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_workorder_update;
        }
        return false;
    }

    /**
     * Determine whether the user can finish the WorkOrder.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrder  $WorkOrder
     * @return mixed
     */
    public function finish(User $user, WorkOrder $WorkOrder)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_workorder_finish;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_workorder_finish;
        }
        return false;
    }

    public function addPhoto(User $user, WorkOrder $WorkOrder)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_workorder_addPhoto;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_workorder_addPhoto;
        }
        return false;
    }

    public function removePhoto(User $user, WorkOrder $WorkOrder)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_workorder_removePhoto;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_workorder_removePhoto;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the WorkOrder.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrder  $WorkOrder
     * @return mixed
     */
    public function delete(User $user, WorkOrder $WorkOrder)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_workorder_delete;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }
}
