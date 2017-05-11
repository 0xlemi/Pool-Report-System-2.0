<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Company' => 'App\Policies\CompanyPolicy',
        'App\UserRoleCompany' => 'App\Policies\UserRoleCompanyPolicy',
        'App\Report' => 'App\Policies\ReportPolicy',
        'App\WorkOrder' => 'App\Policies\WorkOrderPolicy',
        'App\Work' => 'App\Policies\WorkPolicy',
        'App\Service' => 'App\Policies\ServicePolicy',
        'App\ServiceContract' => 'App\Policies\ContractPolicy',
        'App\Measurement' => 'App\Policies\MeasurementPolicy',
        'App\Product' => 'App\Policies\ProductPolicy',
        'App\Equipment' => 'App\Policies\EquipmentPolicy',
        'App\Invoice' => 'App\Policies\InvoicePolicy',
        'App\Payment' => 'App\Policies\PaymentPolicy',
        'App\Setting' => 'App\Policies\SettingPolicy',
        'App\PermissionRoleCompany' => 'App\Policies\PermissionPolicy',
        'App\GlobalMeasurement' => 'App\Policies\GlobalMeasurementPolicy',
        'App\GlobalProduct' => 'App\Policies\GlobalProductPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addDays(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(60));
    }
}
