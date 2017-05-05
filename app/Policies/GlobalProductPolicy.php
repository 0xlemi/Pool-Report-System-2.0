<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GlobalProductPolicy
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
        return $user->selectedUser->hasPermission('globalproduct', 'view');
    }

    /**
     * Determine whether the user can view the globalproduct.
     *
     * @param  \App\User  $user
     * @param  \App\GlobalProduct   globalproduct$
     * @return mixed
     */
    public function view(User $user, GlobalProduct $globalProduct)
    {
        return $user->selectedUser->hasPermission('globalproduct', 'view');
    }

    /**
     * Determine whether the user can create globalproducts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->selectedUser->hasPermission('globalproduct', 'create');
    }

    /**
     * Determine whether the user can update the globalproduct.
     *
     * @param  \App\User  $user
     * @param  \App\GlobalProduct   globalproduct$
     * @return mixed
     */
    public function update(User $user, GlobalProduct $globalProduct)
    {
        return $user->selectedUser->hasPermission('globalproduct', 'update');
    }

    public function addPhoto(User $user, GlobalProduct $globalProduct)
    {
        return $user->selectedUser->hasPermission('globalproduct', 'addPhoto');
    }

    public function removePhoto(User $user, GlobalProduct $globalProduct)
    {
        return $user->selectedUser->hasPermission('globalproduct', 'removePhoto');
    }

    /**
     * Determine whether the user can delete the globalproduct.
     *
     * @param  \App\User  $user
     * @param  \App\GlobalProduct   globalproduct$
     * @return mixed
     */
    public function delete(User $user, GlobalProduct $globalProduct)
    {
        return $user->selectedUser->hasPermission('globalproduct', 'delete');
    }

}
