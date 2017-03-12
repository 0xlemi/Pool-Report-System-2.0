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
        $admin = $invoice->admin();
        $admin->user->notify(new NewInvoiceNotification($invoice, \Auth::user()));
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
