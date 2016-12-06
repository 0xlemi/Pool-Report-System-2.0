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
        if($user->isAdministrator()){
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
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_contract_show;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_contract_show;
        }
        return false;
    }

    /**
     * Determine whether the user can create serviceContracts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_contract_create;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_contract_create;
        }
        return false;
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
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_contract_edit;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_contract_edit;
        }
        return false;
    }

    public function deactivate(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_contract_deactivate;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_contract_deactivate;
        }
        return false;
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
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_contract_destroy;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_contract_destroy;
        }
        return false;
    }
}
