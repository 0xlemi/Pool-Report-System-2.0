<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Jobs\RecordServiceHistory;
use App\Jobs\RemoveExpiredUrlSigners;
use App\Jobs\UpdateSubscriptionQuantity;
use App\Jobs\GenerateInvoicesForContracts;
use App\Company;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\imageVariousSizes::class,
        Commands\ClearLog::class,
        Commands\UpdateSubscriptionQuantity::class,
        Commands\AddDeviceMagicForms::class,
        Commands\CreateContractInvoicesTodayCommand::class,
        Commands\CreateContactInvoice::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // add invoices to serviceContracts that their day is do
        $schedule->call(function () {
            foreach (Company::all() as $company) {
                dispatch(new GenerateInvoicesForContracts($company));
            }
        })->daily();

        // remove UrlSigners that are expired
        $schedule->call(function () {
            dispatch(new RemoveExpiredUrlSigners());
        })->daily();

        // set the missing services history for yesterday
        $schedule->call(function () {
            dispatch(new RecordServiceHistory());
        })->daily();

        // Update the stripe tech and sub user quantity for all companies
        $schedule->call(function () {
            foreach (Company::all() as $company) {
                dispatch(new UpdateSubscriptionQuantity($company));
            }
        })->daily();

    }
}
