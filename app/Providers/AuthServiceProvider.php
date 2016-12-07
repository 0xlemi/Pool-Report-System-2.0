<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        'App\WorkOrder' => 'App\Policies\WorkOrderPolicy',
        'App\Work' => 'App\Policies\WorkPolicy',
        'App\Client' => 'App\Policies\ClientPolicy',
        'App\Service' => 'App\Policies\ServicePolicy',
        'App\ServiceContract' => 'App\Policies\ContractPolicy',
        'App\Chemical' => 'App\Policies\ChemicalPolicy',
        'App\Equipment' => 'App\Policies\EquipmentPolicy',
        'App\Supervisor' => 'App\Policies\SupervisorPolicy',
        'App\Technician' => 'App\Policies\TechnicianPolicy',
        'App\Invoice' => 'App\Policies\InvoicePolicy',
        'App\Payment' => 'App\Policies\PaymentPolicy',
        'App\Setting' => 'App\Policies\SettingPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
