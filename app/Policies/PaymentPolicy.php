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
        if($user->selectedUser->isRole('admin')){
            return true;
        }
    }

    public function list(User $user)
    {
        return $user->selectedUser->hasPermission('payment', 'view');
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
        $urc = $user->selectedUser;
        if($urc->isRole('client')){
            return ($urc->invoices()->payments()->where('payments.id', $payment->id)->first()) ? true : false;
        }
        return $urc->hasPermission('payment', 'view');
    }

    /**
     * Determine whether the user can create payment.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->selectedUser->hasPermission('payment', 'create');
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
        return $user->selectedUser->hasPermission('payment', 'delete');
    }
}
