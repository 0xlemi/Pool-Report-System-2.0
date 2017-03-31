<?php

namespace App\PRS\Observers;

use App\ServiceContract;
use App\Notifications\AddedContractNotification;
use Carbon\Carbon;

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
        // // check invoice for date
        // if($contract->checkIfTodayContractChargesInvoice(false)){
        //
        //     $now = Carbon::now($contract->admin()->timezone);
        //     $month = $now->format('F');
        //     $year = $now->format('Y');
        //
        //     $contract->invoices()->create([
        //         'amount' => $contract->amount,
        //         'currency' => $contract->currency,
        //         'description' => "Pool Cleaning Service and Manteniance for {$month} of {$year}",
        //         'admin_id' => $contract->admin()->id,
        //     ]);
        // }

        // // Notify:
        //     //  System Admin,
        //     //  All Admin Supervisors,
        //     //  Clients related to the service
        // $authUser = \Auth::user();
        // $admin = $contract->admin();
        // $admin->user->notify(new AddedContractNotification($contract, $authUser));
        // foreach ($admin->supervisors as $supervisor) {
        //     $supervisor->user->notify(new AddedContractNotification($contract, $authUser));
        // }
        // foreach ($contract->service->clients as $client) {
        //     $client->user->notify(new AddedContractNotification($contract, $authUser));
        // }

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
