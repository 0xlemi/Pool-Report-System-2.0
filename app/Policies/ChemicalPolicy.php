<?php

namespace App\Policies;

use App\User;
use App\Chemical;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChemicalPolicy
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
            return $user->userable()->admin()->sup_chemical_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_chemical_view;
        }
        return false;
    }

    /**
     * Determine whether the user can view the chemical.
     *
     * @param  \App\User  $user
     * @param  \App\Chemical  $chemical
     * @return mixed
     */
    public function view(User $user, Chemical $chemical)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_chemical_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_chemical_view;
        }
        return false;
    }

    /**
     * Determine whether the user can create chemicals.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_chemical_create;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_chemical_create;
        }
        return false;
    }

    /**
     * Determine whether the user can update the chemical.
     *
     * @param  \App\User  $user
     * @param  \App\Chemical  $chemical
     * @return mixed
     */
    public function update(User $user, Chemical $chemical)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_chemical_update;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_chemical_update;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the chemical.
     *
     * @param  \App\User  $user
     * @param  \App\Chemical  $chemical
     * @return mixed
     */
    public function delete(User $user, Chemical $chemical)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_chemical_delete;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_chemical_delete;
        }
        return false;
    }
}
