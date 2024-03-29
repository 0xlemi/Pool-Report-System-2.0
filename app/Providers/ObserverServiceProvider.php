<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\User;
use App\Work;
use App\ServiceContract;
use App\UserRoleCompany;
use App\Client;
use App\Report;
use App\Administrator;
use App\Supervisor;
use App\Technician;
use App\Image;
use App\Service;
use App\Invoice;
use App\Payment;
use App\Company;
use App\WorkOrder;
use App\Equipment;

use App\PRS\Observers\UserObserver;
use App\PRS\Observers\WorkObserver;
use App\PRS\Observers\ImageObserver;
use App\PRS\Observers\ClientObserver;
use App\PRS\Observers\ReportObserver;
use App\PRS\Observers\ServiceObserver;
use App\PRS\Observers\InvoiceObserver;
use App\PRS\Observers\PaymentObserver;
use App\PRS\Observers\CompanyObserver;
use App\PRS\Observers\ContractObserver;
use App\PRS\Observers\EquipmentObserver;
use App\PRS\Observers\WorkOrderObserver;
use App\PRS\Observers\SupervisorObserver;
use App\PRS\Observers\TechnicianObserver;
use App\PRS\Observers\AdministratorObserver;
use App\PRS\Observers\UserRoleCompanyObserver;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Company::observe(CompanyObserver::class);
        ServiceContract::observe(ContractObserver::class);
        Equipment::observe(EquipmentObserver::class);
        Image::observe(ImageObserver::class);
        Report::observe(ReportObserver::class);
        Service::observe(ServiceObserver::class);
        User::observe(UserObserver::class);
        UserRoleCompany::observe(UserRoleCompanyObserver::class);
        Work::observe(WorkObserver::class);
        WorkOrder::observe(WorkOrderObserver::class);
        Invoice::observe(InvoiceObserver::class);
        Payment::observe(PaymentObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
