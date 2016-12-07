<?php

namespace App\Policies;

use App\User;
use App\Payment;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
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
            return $user->userable()->admin()->sup_payment_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_payment_view;
        }
        return false;
    }

    /**
     * Determine whether the user can view the payment.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function view(User $user, Payment $payment)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_payment_view;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_payment_view;
        }
        return false;
    }

    /**
     * Determine whether the user can create payment.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_payment_create;
        }elseif($user->isTechnician()){
            return $user->userable()->admin()->tech_payment_create;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the payment.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function delete(User $user, Payment $payment)
    {
        if($user->isSupervisor()){
            return $user->userable()->admin()->sup_payment_delete;
        }elseif($user->isTechnician()){
            return false;
        }
        return false;
    }
}
