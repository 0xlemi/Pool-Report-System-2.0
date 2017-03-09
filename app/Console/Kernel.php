<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ClearLog;
use App\Jobs\RemoveExpiredUrlSigners;
use App\Jobs\GenerateInvoicesForContracts;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        Commands\imageVariousSizes::class,
        Commands\ClearLog::class
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
            dispatch(new GenerateInvoicesForContracts());
        })->daily();
        
        // remove UrlSigners that are expired
        $schedule->call(function () {
            dispatch(new RemoveExpiredUrlSigners());
        })->daily();

    }
}
