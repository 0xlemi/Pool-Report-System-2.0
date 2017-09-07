<?php
namespace App\PRS\Classes\Schedules;
use App\Company;
use App\Invoice;
use App\Notifications\NewInvoiceNotification;
use Carbon\Carbon;

class GenerateInvoices{

    protected $company;

    /**
     * Create a new job instance.
     *
     * @return void
    */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function createInoviceFromContract($contract, Carbon $carbon)
    {
        $month = $carbon->format('F');
        $year = $carbon->format('Y');

        // disable observers
        Invoice::flushEventListeners();

        $invoice =  $contract->invoices()->create([
            'amount' => $contract->amount,
            'currency' => $contract->currency,
            'description' => "Pool Cleaning Service and Manteniance for {$month} of {$year}",
            'pay_before' => $carbon->addDays(20),
            'company_id' => $contract->company->id,
        ]);

        // Notifications
        $people = $this->company->userRoleCompanies()->ofRole('admin', 'supervisor')->get();
        foreach ($people as $person){
            $person->notify(new NewInvoiceNotification($invoice));
        }
        foreach ($invoice->invoiceable->service->userRoleCompanies as $client) {
            $client->notify(new NewInvoiceNotification($invoice));
        }

        return $invoice;
    }
}
