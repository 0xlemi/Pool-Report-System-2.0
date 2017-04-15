<?php

namespace App\Policies;

use App\User;
use App\Work;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkPolicy
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
        return $user->selectedUser->hasPermission('work', 'view');
    }

    /**
     * Determine whether the user can view the work.
     *
     * @param  \App\User  $user
     * @param  \App\Work  $work
     * @return mixed
     */
    public function view(User $user, Work $work)
    {
        if($user->selectedUser->isRole('admin')){
            // ****** Security Bug ********
            // client can look at works that are not his
            // To resolve: need to fix this function so the client->works()
            // return $user->userable()->hasWork($work->id);
            return false; // temporary
        }
        return $user->selectedUser->hasPermission('work', 'view');
    }

    /**
     * Determine whether the user can create works.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->selectedUser->hasPermission('work', 'create');
    }

    /**
     * Determine whether the user can update the work.
     *
     * @param  \App\User  $user
     * @param  \App\Work  $work
     * @return mixed
     */
    public function update(User $user, Work $work)
    {
        return $user->selectedUser->hasPermission('work', 'update');
    }

    public function addPhoto(User $user, Work $work)
    {
        return $user->selectedUser->hasPermission('work', 'addPhoto');
    }

    public function removePhoto(User $user, Work $work)
    {
        return $user->selectedUser->hasPermission('work', 'removePhoto');
    }

    /**
     * Determine whether the user can delete the work.
     *
     * @param  \App\User  $user
     * @param  \App\Work  $work
     * @return mixed
     */
    public function delete(User $user, Work $work)
    {
        return $user->selectedUser->hasPermission('work', 'delete');
    }
}
