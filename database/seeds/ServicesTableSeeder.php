<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\ServiceContract;
use App\Invoice;
use App\Service;
use App\Payment;
use App\Image;
use App\Notifications\NewServiceNotification;
use App\Notifications\NewInvoiceNotification;
use App\Notifications\NewPaymentNotification;
use App\Notifications\AddedContractNotification;
use App\Administrator;
use Carbon\Carbon;
class ServicesTableSeeder extends Seeder
{
    // number of services to create
    private $number_of_services = 40;
    private $withNotifications = true;
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
    	for ($i=0; $i < $this->number_of_services; $i++) {
		    // generate and save image and tn_image
			$img = $this->seederHelper->get_random_image('service', 20);

            // get a random admin_id that exists in database
        	$adminId = $this->seederHelper->getRandomObject('administrators');
            $admin = Administrator::findOrFail($adminId);

    		$serviceId = factory(App\Service::class)->create([
        		'admin_id' => $admin->id,
            ])->id;
            $service = Service::findOrFail($serviceId);

            if(rand(0,1)){
                factory(App\ServiceContract::class)->create([
                    'service_id' => $service->id,
                ]);
                $contract = ServiceContract::findOrFail($serviceId);
                // // Generate Invoices with Payments
                for ($o=0; $o < rand(1,4); $o++) {
                    $invoiceId = $contract->invoices()->create([
                        'closed' => (rand(0,1)) ? Carbon::createFromDate(2016, rand(1,12), rand(1,28)) : NULL,
                        'amount' => $contract->amount,
                        'currency' => $contract->currency,
                        'admin_id' => $admin->id,
                    ])->id;
                    $invoice = Invoice::findOrFail($invoiceId);
                    $numberPayments = rand(0,3);
                    for ($a=0; $a < $numberPayments; $a++) {
                        $paymentId = $invoice->payments()->create([
                            'amount' => $invoice->amount / $numberPayments,
                        ])->id;
                        $payment = Payment::findOrFail($paymentId);
                    }
                }

            }

            for ($e=0; $e < rand(2,5); $e++) {
                factory(App\Chemical::class)->create([
                    'service_id' => $service->id,
                ]);
            }

            // create images link it to client
            $service->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'processing' => 0,
            ]);
    	}
    }
}
