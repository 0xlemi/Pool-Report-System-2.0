<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Company;
use App\PRS\Classes\Schedules\GenerateInvoices;
use Carbon\Carbon;

class CreateContactInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Invoice based on contract of the service';

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
        $companyOptions = Company::all()->transform(function ($item){
                return $item->id.' '.$item->name;
            })->toArray();

        $choosedCompany = $this->choice('What is company?', $companyOptions);
        $company = Company::findOrFail(explode(" ", $choosedCompany)[0]);

        $servicesOptions = $company->services()->withActiveContract()->get()->transform(function ($item) {
            return $item->seq_id.' '.$item->name;
        })->toArray();

        $choosedService = $this->choice('What is service?', $servicesOptions);
        $service = $company->services()->bySeqId(explode(" ", $choosedService)[0]);

        $generateInvoices = new GenerateInvoices($company);

        $invoice = $generateInvoices->createInoviceFromContract($service->serviceContract, Carbon::now());

        $this->info("Invoice {$invoice->seq_id} generated.");

    }
}
