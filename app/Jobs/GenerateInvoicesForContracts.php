<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ServiceContract;
use Carbon\Carbon;

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

                $now = Carbon::now($contract->admin()->timezone);
                $month = $now->format('F');
                $year = $now->format('Y');

                $contract->invoices()->create([
                    'amount' => $contract->amount,
                    'currency' => $contract->currency,
                    'description' => "Pool Cleaning Service and Manteniance for {$month} of {$year}",
                    'admin_id' => $contract->admin()->id,
                ]);

            }
        }
    }
}
