<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ServiceContract;

class GenerateInvoicesForContracts implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $contracts = ServiceContract::all();

        foreach ($contracts as $contract) {
            if($contract->checkIfTodayContractChargesInvoice()){
                $contract->invoices()->create([
                    'amount' => $contract->amount,
                    'currency' => $contract->currency,
                    'admin_id' => $contract->admin()->id,
                ]);
            }
        }
    }
}
