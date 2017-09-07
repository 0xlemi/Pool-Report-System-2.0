<?php

namespace App\PRS\Observers;

use App\Invoice;
use App\Notifications\NewInvoiceNotification;
use App\PRS\Classes\Logged;

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
        $urc = Logged::user()->selectedUser;
        // Notifications
        $people = $urc->company->userRoleCompanies()->ofRole('admin', 'supervisor')->get();
        foreach ($people as $person){
            $person->notify(new NewInvoiceNotification($invoice));
        }
        foreach ($invoice->invoiceable->service->userRoleCompanies as $client) {
            $client->notify(new NewInvoiceNotification($invoice));
        }
    }

    /**
     * Listen to the Invoice deleting event.
     *
     * @param  Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        //
    }
}
