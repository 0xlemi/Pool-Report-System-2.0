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
        $user = auth()->user();
        $people = $user->selectedUser->company->userRoleCompanies()->ofRole('admin', 'supervisor');
        foreach ($people as $person){
            $person->notify(new NewPaymentNotification($payment, $user));
        }
        foreach ($payment->invoice->invoiceable->service->userRoleCompanies as $client) {
            $client->notify(new NewPaymentNotification($payment, $user));
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
