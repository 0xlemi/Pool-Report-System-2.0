<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Administrator;
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
        $admins = Administrator::all();

        foreach ($admins as $admin) {
            $yesterday = Carbon::today($admin->timezone)->subDays(1);

            $servicesMissing = $admin->servicesDoIn($yesterday);
            $numServicesMissing = $admin->numberServicesMissing($yesterday);
            $numServicesDone = $admin->numberServicesDoIn($yesterday) - $numServicesMissing;

            $missingHistory = $admin->missingHistories()->create([
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
