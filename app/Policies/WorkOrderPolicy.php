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
        if($user->selectedUser->isRole('admin')){
            return true;
        }
    }

    public function list(User $user)
    {
        return $user->selectedUser->hasPermission('workorder_view');
    }

    /**
     * Determine whether the user can view the WorkOrder.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrder  $workOrder
     * @return mixed
     */
    public function view(User $user, WorkOrder $workOrder)
    {
        if($user->selectedUser->isRole('client')){
            // only if this client owns this workorder
            // return $user->selectedUser->hasWorkOrder($workOrder->seq_id);
            return false; // temporary
        }
        return $user->selectedUser->hasPermission('workorder_view');
    }

    /**
     * Determine whether the user can create WorkOrders.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->selectedUser->hasPermission('workorder_create');
    }

    /**
     * Determine whether the user can update the WorkOrder.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrder  $workOrder
     * @return mixed
     */
    public function update(User $user, WorkOrder $workOrder)
    {
        $isNotFinished = !$workOrder->end()->finished();
        return ($user->selectedUser->hasPermission('workorder_update') && $isNotFinished );
    }

    /**
     * Determine whether the user can finish the WorkOrder.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrder  $workOrder
     * @return mixed
     */
    public function finish(User $user, WorkOrder $workOrder)
    {
        $isNotFinished = !$workOrder->end()->finished();
        return ($user->selectedUser->hasPermission('workorder_finish') && $isNotFinished );
    }

    public function addPhoto(User $user, WorkOrder $workOrder)
    {
        return $user->selectedUser->hasPermission('workorder_addPhoto');
    }

    public function removePhoto(User $user, WorkOrder $workOrder)
    {
        return $user->selectedUser->hasPermission('workorder_removePhoto');
    }

    /**
     * Determine whether the user can delete the WorkOrder.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrder  $workOrder
     * @return mixed
     */
    public function delete(User $user, WorkOrder $workOrder)
    {
        return $user->selectedUser->hasPermission('workorder_delete');
    }
}
