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
        // Notify:
            // System admin
            // Supervisors
            // Payment Related Clients
        $authUser = \Auth::user();
        $admin = $payment->admin();
        $service = $payment->invoice->invoiceable->service;

        $admin->user->notify(new NewPaymentNotification($payment, $authUser));
        foreach ($admin->supervisors as $supervisor) {
            $supervisor->user->notify(new NewPaymentNotification($payment, $authUser));
        }
        foreach ($service->clients as $client) {
            $client->user->notify(new NewPaymentNotification($payment, $authUser));
        }

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
