<?php

namespace App\Policies;

use App\User;
use App\Role;
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
        if($user->selectedUser->isRole('admin')){
            return true;
        }
    }

    /**
     * Determine whether the user can view the list of userRoleCompany with role client.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user, $role)
    {
        if($role == 'client'){
            return $user->selectedUser->hasPermission('client', 'view');
        }elseif($role == 'sup'){
            return $user->selectedUser->hasPermission('supervisor', 'view');
        }elseif($role == 'tech'){
            return $user->selectedUser->hasPermission('technician', 'view');
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
        $role = $userRoleCompany->role->name;
        if($role == 'client'){
            return $user->selectedUser->hasPermission('client', 'view');
        }elseif($role == 'sup'){
            return $user->selectedUser->hasPermission('supervisor', 'view');
        }elseif($role == 'tech'){
            return $user->selectedUser->hasPermission('technician', 'view');
        }
    }

    /**
     * Determine whether the user can create userRoleCompanies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, $role)
    {
        if($role == 'client'){
            return $user->selectedUser->hasPermission('client', 'create');
        }elseif($role == 'sup'){
            return $user->selectedUser->hasPermission('supervisor', 'create');
        }elseif($role == 'tech'){
            return $user->selectedUser->hasPermission('technician', 'create');
        }
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
        $role = $userRoleCompany->role->name;
        if($role == 'client'){
            return $user->selectedUser->hasPermission('client', 'update');
        }elseif($role == 'sup'){
            return $user->selectedUser->hasPermission('supervisor', 'update');
        }elseif($role == 'tech'){
            return $user->selectedUser->hasPermission('technician', 'update');
        }
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
        $role = $userRoleCompany->role->name;
        if($role == 'client'){
            return $user->selectedUser->hasPermission('client', 'delete');
        }elseif($role == 'sup'){
            return $user->selectedUser->hasPermission('supervisor', 'delete');
        }elseif($role == 'tech'){
            return $user->selectedUser->hasPermission('technician', 'delete');
        }
    }
}
