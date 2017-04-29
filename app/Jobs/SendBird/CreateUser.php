<?php

namespace App\Jobs\SendBird;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\PRS\Classes\SendBird;
use App\UserRoleCompany;

class CreateUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected  $userRoleCompany;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UserRoleCompany $userRoleCompany)
    {
        $this->userRoleCompany = $userRoleCompany;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SendBird::create($this->userRoleCompany);
    }
}
