<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Company;
use App\PRS\Classes\Schedules\GenerateInvoices;
use Carbon\Carbon;

class CreateContractInvoicesTodayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:contractsToday {company_id} {day=default : days of the month the invoice is due.} {description=default : Description in the invoices created}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create invoices for all the service contracts that payment is due in a day of the month.';

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
        $company = Company::findOrFail($this->argument('company_id'));

        $generateInvoices = new GenerateInvoices($company);

        $contracts = $company->services()->contracts()->active(true)->get();

        if($contracts->count() < 1 ){
            $this->info('No active contracts with today as generation day.');
            return null;
        }
        $all = [];
        $count = 0;
        $day = ($this->argument('day') != "default") ?: Carbon::today($company->timezone)->format('d');
        foreach ($contracts as $contract) {
            if($contract->checkIfInDayContractInvoiceIsDo(true, $day)){
                $generateInvoices->createInoviceFromContract($contract, Carbon::now());
                $count++;
            }

        }
        if($count == 0){
            $this->info("No invocies needed to be created for the day.");
        }else{
            $this->info("There where {$count} invoices created.");
        }
    }
}
