<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\ServiceContract;
use App\Invoice;
use App\Service;
use App\Payment;
use App\Company;
use App\Image;
use App\Notifications\NewServiceNotification;
use App\Notifications\NewInvoiceNotification;
use App\Notifications\NewPaymentNotification;
use App\Notifications\AddedContractNotification;
use App\Measurement;
use Carbon\Carbon;
class ServicesTableSeeder extends Seeder
{
    // number of services to create
    private $seederHelper;

    public function __construct(SeederHelpers $seederHelper)
    {
        $this->seederHelper = $seederHelper;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $number_of_services = rand(45, 60);

        // Disable observers
        Service::flushEventListeners();
        Measurement::flushEventListeners();
        ServiceContract::flushEventListeners();
        Invoice::flushEventListeners();
        Payment::flushEventListeners();
        Image::flushEventListeners();

    	for ($i=0; $i < $number_of_services ; $i++) {
		    // generate and save image and tn_image
			$img = $this->seederHelper->get_random_image('service', 20);

            // get a random company_id that exists in database
        	$companyId = $this->seederHelper->getRandomObject('companies');
            $company = Company::findOrFail($companyId);

    		$service = factory(Service::class)->create([
        		'company_id' => $company->id,
            ]);
            // create images link it to service
            $service->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'processing' => 0,
            ]);

            if(rand(0,1)){
                $contract = factory(ServiceContract::class)->create([
                    'service_id' => $service->id,
                ]);
                // // Generate Invoices with Payments
                for ($o=0; $o < rand(1,4); $o++) {
                    $invoiceId = $contract->invoices()->create([
                        'closed' => (rand(0,1)) ? Carbon::createFromDate(2016, rand(1,12), rand(1,28)) : NULL,
                        'amount' => $contract->amount,
                        'currency' => $contract->currency,
                        'pay_before' => Carbon::now()->addDays(20),
                        'company_id' => $company->id,
                    ])->id;
                    $invoice = Invoice::findOrFail($invoiceId);
                    $numberPayments = rand(0,3);
                    for ($a=0; $a < $numberPayments; $a++) {
                        $methods = [
                            'cash',
                            'transfer',
                            'check',
                            'credit_card',
                            'debit',
                            'atm_withdrawals',
                            'connect'
                        ];
                        $method = $methods[rand(0,6)];
                        $paymentId = $invoice->payments()->create([
                            'amount' => $invoice->amount / $numberPayments,
                            'method' => $method,
                            'verified' => ($method == 'connect'),
                        ])->id;
                        $payment = Payment::findOrFail($paymentId);
                    }
                }

            }

            for($e=0; $e < rand(6,7); $e++) {

                // Getting a valid Global Measurement ID
                $usedGlobalMeasurements = $service->measurements()
                            ->join('global_measurements', 'global_measurement_id', '=', 'global_measurements.id')
                            ->pluck('global_measurements.id')->toArray();
                $global_measurement_id = $service->company->globalMeasurements()
                                                ->whereNotIn('global_measurements.id', $usedGlobalMeasurements)
                                                ->get()->random()->id;

                $service->measurements()->create([
                    'global_measurement_id' => $global_measurement_id,
                ]);
            }

            for($e=0; $e < rand(3,4); $e++) {

                // Getting a valid Global Product ID
                $usedGlobalProducts = $service->products()
                            ->join('global_products', 'global_product_id', '=', 'global_products.id')
                            ->pluck('global_products.id')->toArray();
                $global_product_id = $service->company->globalProducts()
                                                ->whereNotIn('global_products.id', $usedGlobalProducts)
                                                ->get()->random()->id;

                $service->products()->create([
                    'amount' => number_format(rand(100,100000)/100, 2, '.', ''),
                    'global_product_id' => $global_product_id,
                ]);
            }


    	}
    }
}
