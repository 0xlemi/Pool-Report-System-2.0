<?php

namespace App\PRS\Observers;

use App\Invoice;
use App\Notifications\NewInvoiceNotification;

class InvoiceObserver
{
    /**
     * Listen to the Invoice created event.
     *
     * @param  Invoice  $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        // // Notify:
        //     // System admin
        //     // Supervisors
        //     // Invoice Related Clients
        // $authUser = \Auth::user();
        // $admin = $invoice->admin();
        // $service = $invoice->invoiceable->service;
        // $admin->user->notify(new NewInvoiceNotification($invoice, $authUser));
        // foreach ($admin->supervisors as $supervisor) {
        //     $supervisor->user->notify(new NewInvoiceNotification($invoice, $authUser));
        // }
        // foreach ($service->clients as $client) {
        //     $client->user->notify(new NewInvoiceNotification($invoice, $authUser));
        // }

    }

    /**
     * Listen to the Invoice deleting event.
     *
     * @param  Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
    }
}
