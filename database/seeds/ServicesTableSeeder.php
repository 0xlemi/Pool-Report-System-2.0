<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\ServiceContract;
use App\Invoice;
use App\Image;
use Carbon\Carbon;
class ServicesTableSeeder extends Seeder
{
    // number of services to create
    private $number_of_services = 40;
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
			$img = $this->seederHelper->get_random_image('service', 'service', rand(1, 20));

            // get a random admin_id that exists in database
        	$adminId = $this->seederHelper->getRandomObject('administrators');

    		$service = factory(App\Service::class)->create([
        		'admin_id' => $adminId,
            ]);

            if(rand(0,1)){
                factory(App\ServiceContract::class)->create([
                    'service_id' => $service->id,
                ]);
                $contract = ServiceContract::findOrFail($service->id);

                // // Generate Invoices with Payments
                for ($o=0; $o < rand(1,4); $o++) {
                    $invoice = $contract->invoices()->create([
                        'closed' => (rand(0,1)) ? Carbon::createFromDate(2016, rand(1,12), rand(1,28)) : NULL,
                        'amount' => $contract->amount,
                        'currency' => $contract->currency,
                        'admin_id' => $adminId,
                    ]);
                    $numberPayments = rand(0,3);
                    for ($a=0; $a < $numberPayments; $a++) {
                        $invoice->payments()->create([
                            'amount' => $invoice->amount / $numberPayments,
                        ]);
                    }
                }

            }

            for ($e=0; $e < rand(2,5); $e++) {
                factory(App\Chemical::class)->create([
                    'service_id' => $service->id,
                ]);
            }

    		// create images link it to service id
    		// normal image
    		Image::create([
    			'service_id' => $service->id,
    			'normal_path' => $img['img_path'],
                'thumbnail_path' => $img['tn_img_path'],
                'icon_path' => $img['xs_img_path'],
    		]);
    	}
    }
}
