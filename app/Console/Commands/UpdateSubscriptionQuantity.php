<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Company;

class UpdateSubscriptionQuantity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:updateQuantity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the subscription quantity of all the companies in the system.';

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

        $bar = $this->output->createProgressBar($companies->count());
        foreach ($companies as $key => $company) {
            if ($company->subscribed('main')) {
                $company->subscription('main')->updateQuantity($company->billableObjects());
            }
            $bar->advance();
        }

        $bar->finish();
    }
}
