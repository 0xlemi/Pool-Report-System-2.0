<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Company;
use Carbon\Carbon;

class RecordServiceHistory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            $yesterday = Carbon::today($company->timezone)->subDays(1);

            $servicesMissing = $company->servicesDoIn($yesterday);
            $numServicesMissing = $company->numberServicesMissing($yesterday);
            $numServicesDone = $company->numberServicesDoIn($yesterday) - $numServicesMissing;

            $missingHistory = $company->missingHistories()->create([
                'date' => $yesterday,
                'num_services_missing' => $numServicesMissing,
                'num_services_done' => $numServicesDone
            ]);
            foreach ($servicesMissing as $service) {
                $missingHistory->services()->attach($service->id);
            }
        }
    }
}
