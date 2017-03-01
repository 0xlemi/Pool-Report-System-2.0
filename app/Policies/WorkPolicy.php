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
        if($user->isAdministrator()){
            return true;
        }
    }

    public function list(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_work_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_work_view;
        }elseif($user->isClient()){
            return true;
        }
        return false;
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
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_work_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_work_view;
        }elseif($user->isClient()){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create works.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_work_create;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_work_create;
        }
        return false;
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
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_work_update;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_work_update;
        }
        return false;
    }

    public function addPhoto(User $user, Work $work)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_work_addPhoto;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_work_addPhoto;
        }
        return false;
    }

    public function removePhoto(User $user, Work $work)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_work_removePhoto;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_work_removePhoto;
        }
        return false;
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
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_work_delete;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_work_delete;
        }
        return false;
    }
}
