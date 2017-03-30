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
        if($user->activeUser->isRole('admin')){
            return true;
        }
    }

    public function list(User $user)
    {
        return $user->activeUser->hasPermission('payment_view');
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
        return $user->activeUser->hasPermission('payment_view');
    }

    /**
     * Determine whether the user can create payment.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->activeUser->hasPermission('payment_create');
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
        return $user->activeUser->hasPermission('payment_delete');
    }
}
