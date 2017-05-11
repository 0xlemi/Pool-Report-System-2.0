<?php

namespace App\Policies;

use App\User;
use App\PermissionRoleCompany;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
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
     * Determine whether the user can view list of the PermissionRoleCompany.
     *
     * @param  \App\User  $user
     * @param  \App\PermissionRoleCompany  $PermissionRoleCompany
     * @return mixed
     */
    public function list(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the PermissionRoleCompany.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can create =PermissionRoleCompanies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the PermissionRoleCompany.
     *
     * @param  \App\User  $user
     * @param  \App\PermissionRoleCompany  $PermissionRoleCompany
     * @return mixed
     */
    public function delete(User $user, PermissionRoleCompany $PermissionRoleCompany)
    {
        return false;
    }
}
