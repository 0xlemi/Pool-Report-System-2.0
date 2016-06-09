<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Report' => 'App\Policies\ReportPolicy',
        'App\Client' => 'App\Policies\ClientPolicy',
        'App\Service' => 'App\Policies\ServicePolicy',
        'App\Supervisor' => 'App\Policies\SupervisorPolicy',
        'App\Technician' => 'App\Policies\TechnicianPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
