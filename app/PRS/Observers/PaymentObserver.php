<?php

namespace App\PRS\Observers;

use App\Payment;
use App\Notifications\NewPaymentNotification;

class PaymentObserver
{
    /**
     * Listen to the Payment created event.
     *
     * @param  Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        $admin = $payment->admin();
        $admin->user->notify(new NewPaymentNotification($payment, \Auth::user()));
    }

    /**
     * Listen to the Payment deleting event.
     *
     * @param  Payment  $payment
     * @return void
     */
    public function deleted(Payment $payment)
    {

    }
}
