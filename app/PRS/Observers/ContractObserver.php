<?php

namespace App\PRS\Observers;

use App\ServiceContract;
use App\Notifications\AddedContractNotification;
use App\PRS\Classes\Logged;
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
        // check invoice for date
        if($contract->checkIfTodayContractChargesInvoice(false)){

            $company = $contract->company;
            $now = Carbon::now($company->timezone);
            $month = $now->format('F');
            $year = $now->format('Y');

            $contract->invoices()->create([
                'amount' => $contract->amount,
                'currency' => $contract->currency,
                'description' => "Pool Cleaning Service and Manteniance for {$month} of {$year}",
                'pay_before' => Carbon::now()->addDays(20),
                'company_id' => $company->id,
            ]);
        }

        //  Notificitions
        $urc = Logged::user()->selectedUser;
        $people = $urc->company->userRoleCompanies()->ofRole('admin', 'supervisor')->get();
        foreach ($people as $person){
            $person->notify(new AddedContractNotification($contract, $urc));
        }
        foreach ($contract->service->userRoleCompanies as $client) {
            $client->notify(new AddedContractNotification($contract, $urc));
        }

    }

    /**
     * Listen to the ServiceContract  deleting event.
     *
     * @param  ServiceContract   $contract
     * @return void
     */
    public function deleting(ServiceContract $contract)
    {
        foreach ($contract->invoices as $invoice) {
            $invoice->delete();
        }
    }
}
