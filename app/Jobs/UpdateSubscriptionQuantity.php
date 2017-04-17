<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Company;

class UpdateSubscriptionQuantity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $company;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->company->subscribed('main')) {
            $this->company->subscription('main')->updateQuantity($this->company->billableObjects());
        }
    }
}
