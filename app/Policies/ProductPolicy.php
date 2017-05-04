<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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
        return $user->selectedUser->hasPermission('product', 'view');
    }

    /**
     * Determine whether the user can view the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  product$
     * @return mixed
     */
    public function view(User $user, Product $product)
    {
        return $user->selectedUser->hasPermission('product', 'view');
    }

    /**
     * Determine whether the user can create products.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->selectedUser->hasPermission('product', 'create');
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  product$
     * @return mixed
     */
    public function update(User $user, Product $product)
    {
        return $user->selectedUser->hasPermission('product', 'update');
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  product$
     * @return mixed
     */
    public function delete(User $user, Product $product)
    {
        return $user->selectedUser->hasPermission('product', 'delete');
    }

}
