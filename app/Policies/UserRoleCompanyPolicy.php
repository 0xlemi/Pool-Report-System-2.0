<?php

namespace App\Policies;

use App\User;
use App\UserRoleCompany;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserRoleCompanyPolicy
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
     * Determine whether the user can view the userRoleCompany.
     *
     * @param  \App\User  $user
     * @param  \App\UserRoleCompany  $userRoleCompany
     * @return mixed
     */
    public function view(User $user, UserRoleCompany $userRoleCompany)
    {
        return true; // temporary
    }

    /**
     * Determine whether the user can create userRoleCompanies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true; // temporary
    }

    /**
     * Determine whether the user can update the userRoleCompany.
     *
     * @param  \App\User  $user
     * @param  \App\UserRoleCompany  $userRoleCompany
     * @return mixed
     */
    public function update(User $user, UserRoleCompany $userRoleCompany)
    {
        return true; // temporary
    }

    /**
     * Determine whether the user can delete the userRoleCompany.
     *
     * @param  \App\User  $user
     * @param  \App\UserRoleCompany  $userRoleCompany
     * @return mixed
     */
    public function delete(User $user, UserRoleCompany $userRoleCompany)
    {
        return true; // temporary
    }
}
