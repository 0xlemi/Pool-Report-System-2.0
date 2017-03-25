<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Administrator;

class UpdateSubscriptionQuantity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $admin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Administrator $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->admin->subscribed('main')) {
            $this->admin->subscription('main')->updateQuantity($this->admin->billableObjects());
        }
    }
}
