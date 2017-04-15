<?php

namespace App\Policies;

use App\User;
use App\ServiceContract;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractPolicy
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

    /**
     * Determine whether the user can view the serviceContract.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceContract  $serviceContract
     * @return mixed
     */
    public function view(User $user, ServiceContract $serviceContract)
    {
        return $user->selectedUser->hasPermission('contract', 'view');
    }

    /**
     * Determine whether the user can create serviceContracts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->selectedUser->hasPermission('contract', 'create');
    }

    /**
     * Determine whether the user can update the serviceContract.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceContract  $serviceContract
     * @return mixed
     */
    public function update(User $user, ServiceContract $serviceContract)
    {
        return $user->selectedUser->hasPermission('contract', 'update');
    }

    public function toggleActivation(User $user)
    {
        return $user->selectedUser->hasPermission('contract', 'deactivate');
    }

    /**
     * Determine whether the user can delete the serviceContract.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceContract  $serviceContract
     * @return mixed
     */
    public function delete(User $user, ServiceContract $serviceContract)
    {
        return $user->selectedUser->hasPermission('contract', 'delete');
    }
}
