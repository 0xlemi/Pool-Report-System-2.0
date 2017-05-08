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
        // Notifications
        $urc = Logged::user()->selectedUser;
        $people = $urc->company->userRoleCompanies()->ofRole('admin', 'supervisor')->get();
        foreach ($people as $person){
            $person->notify(new NewPaymentNotification($payment, $urc));
        }
        foreach ($payment->invoice->invoiceable->service->userRoleCompanies as $client) {
            $client->notify(new NewPaymentNotification($payment, $urc));
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
