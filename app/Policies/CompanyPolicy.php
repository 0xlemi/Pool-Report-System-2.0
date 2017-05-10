<?php

namespace App\Policies;

use App\User;
use App\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
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
     * Determine whether the user can view the Company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $Company
     * @return mixed
     */
    public function view(User $user, Company $Company)
    {
        return false;
    }

    /**
     * Determine whether the user can create =Companies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the Company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $Company
     * @return mixed
     */
    public function update(User $user, Company $Company)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the Company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $Company
     * @return mixed
     */
    public function delete(User $user, Company $Company)
    {
        return false;
    }
}
