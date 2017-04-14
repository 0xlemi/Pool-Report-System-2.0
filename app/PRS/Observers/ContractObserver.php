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
                'company_id' => $company->id,
            ]);
        }

        //  Notificitions
        $user = auth()->user();
        $people = $user->selectedUser->company->userRoleCompanies()->ofRole('admin', 'supervisor');
        foreach ($people as $person){
            $person->user->notify(new AddedContractNotification($contract, $user));
        }
        foreach ($contract->service->userRoleCompanies as $client) {
            $client->user->notify(new AddedContractNotification($contract, $user));
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
