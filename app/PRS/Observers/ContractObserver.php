<?php

namespace App\PRS\Observers;

use App\ServiceContract;
use App\Notifications\AddedContractNotification;

class ContractObserver
{
    /**
     * Listen to the ServiceContract  created event.
     *
     * @param  ServiceContract   $contract
     * @return void
     */
    public function created(ServiceContract $contract)
    {
        // check invoice for date
        if($contract->checkIfTodayContractChargesInvoice()){
            // $contract->invoices()->create([
            //     'amount' => $contract->amount,
            //     'currency' => $contract->currency,
            //     'admin_id' => $contract->admin()->id,
            // ]);
        }
        $admin = $contract->admin();
        $admin->user->notify(new AddedContractNotification($contract, \Auth::user()));
    }

    /**
     * Listen to the ServiceContract  deleting event.
     *
     * @param  ServiceContract   $contract
     * @return void
     */
    public function deleted(ServiceContract $contract)
    {
        foreach ($contract->invoices as $invoice) {
            $invoice->delete();
        }
    }
}
