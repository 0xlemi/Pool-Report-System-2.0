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
        if($user->activeUser->isRole('admin')){
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
            return $user->activeUser->hasPermission('client_view');
        }elseif($role == 'sup'){
            return $user->activeUser->hasPermission('supervisor_view');
        }elseif($role == 'tech'){
            return $user->activeUser->hasPermission('technician_view');
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
            return $user->activeUser->hasPermission('client_view');
        }elseif($role == 'sup'){
            return $user->activeUser->hasPermission('supervisor_view');
        }elseif($role == 'tech'){
            return $user->activeUser->hasPermission('technician_view');
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
            return $user->activeUser->hasPermission('client_create');
        }elseif($role == 'sup'){
            return $user->activeUser->hasPermission('supervisor_create');
        }elseif($role == 'tech'){
            return $user->activeUser->hasPermission('technician_create');
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
            return $user->activeUser->hasPermission('client_update');
        }elseif($role == 'sup'){
            return $user->activeUser->hasPermission('supervisor_update');
        }elseif($role == 'tech'){
            return $user->activeUser->hasPermission('technician_update');
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
            return $user->activeUser->hasPermission('client_delete');
        }elseif($role == 'sup'){
            return $user->activeUser->hasPermission('supervisor_delete');
        }elseif($role == 'tech'){
            return $user->activeUser->hasPermission('technician_delete');
        }
    }
}
