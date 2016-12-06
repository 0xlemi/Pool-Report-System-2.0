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
            return $user->userable()->admin()->sup_work_index;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_work_index;
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
            return $user->userable()->admin()->sup_work_show;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_work_show;
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
            return $user->userable()->admin()->sup_work_edit;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_work_edit;
        }
        return false;
    }

    public function addPhoto(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_work_addPhoto;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_work_addPhoto;
        }
        return false;
    }

    public function removePhoto(User $user)
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
            return $user->userable()->admin()->sup_work_destroy;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_work_destroy;
        }
        return false;
    }
}
