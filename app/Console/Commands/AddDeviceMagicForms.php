<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Company;
use App\PRS\Classes\DeviceMagic\ReportForm;
use App\PRS\Classes\DeviceMagic\Destination;
use App\PRS\Classes\DeviceMagic\WorkOrderForm;

class AddDeviceMagicForms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devicemagic:forms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or Update all the device magic forms for all the companies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $companies = Company::all();
        $bar = $this->output->createProgressBar($companies->count() * 2);
        foreach ($companies as $company) {
            $destination = new Destination($company);

            $reportForm = new ReportForm($destination);
            $reportForm->createOrUpdate();
            $bar->advance();

            $workOrderForm = new WorkOrderForm($destination);
            $workOrderForm->createOrUpdate();
            $bar->advance();
        }

        $bar->finish();
    }
}
