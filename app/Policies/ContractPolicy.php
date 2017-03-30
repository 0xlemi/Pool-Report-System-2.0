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
        if($user->activeUser->isRole('admin')){
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
        return $user->activeUser->hasPermission('contract_view');
    }

    /**
     * Determine whether the user can create serviceContracts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->activeUser->hasPermission('contract_create');
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
        return $user->activeUser->hasPermission('contract_update');
    }

    public function toggleActivation(User $user)
    {
        return $user->activeUser->hasPermission('contract_deactivate');
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
        return $user->activeUser->hasPermission('contract_delete');
    }
}
