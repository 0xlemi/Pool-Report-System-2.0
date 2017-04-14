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
        // Notifications
        $user = auth()->user();
        $people = $user->selectedUser->company->userRoleCompanies()->ofRole('admin', 'supervisor');
        foreach ($people as $person){
            $person->user->notify(new NewInvoiceNotification($invoice, $user));
        }
        foreach ($invoice->invoiceable->service->userRoleCompanies as $client) {
            $client->user->notify(new NewInvoiceNotification($invoice, $user));
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
