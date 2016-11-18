<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\Service;
use App\Supervisor;
use App\Image;

use App\WorkOrder;
use App\Notifications\NewInvoiceNotification;
use App\Notifications\NewPaymentNotification;
use App\Notifications\NewWorkOrderNotification;
use Carbon\Carbon;

class WorkOrdersTableSeeder extends Seeder
{

    private $amount = 100;
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
        for ($i=0; $i < $this->amount; $i++) {

            // get random supervisor
        	$supervisorId = $this->seederHelper->getRandomObject('supervisors');

            // get the user id in of the random technician
        	$admin = Supervisor::findOrFail($supervisorId)->admin();

        	// get a random service that shares the same admin_id
        	// as the supervisor
        	$service = $this->seederHelper->getRandomService($admin);


            $workOrderId = factory(App\WorkOrder::class)->create([
                'service_id' => $service->id,
                'supervisor_id' => $supervisorId,
            ])->id;
            $workOrder = WorkOrder::findOrFail($workOrderId);
            if($this->withNotifications){
                auth()->user()->notify(new NewWorkOrderNotification($workOrder));
            }

            // Generate Invoices with Payments
            for ($o=0; $o < rand(1,4); $o++) {
                    $preInvoice = $workOrder->invoices()->create([
                        'closed' => (rand(0,1)) ? Carbon::createFromDate(2016, rand(1,12), rand(1,28)) : NULL,
                        'amount' => $workOrder->price,
                        'currency' => $workOrder->currency,
                        'admin_id' => $admin->id,
                    ]);
                    $invoice = Invoice::findOrFail($preInvoice->id);
                    if($this->withNotifications){
                        auth()->user()->notify(new NewInvoiceNotification($invoice));
                    }
                    $numberPayments = rand(0,3);
                    for ($a=0; $a < $numberPayments; $a++) {
                        $prePayment = $invoice->payments()->create([
                            'amount' => $invoice->amount / $numberPayments,
                        ]);
                        $payment = Invoice::findOrFail($prePayment->id);
                        if($this->withNotifications){
                            auth()->user()->notify(new NewPaymentNotification($payment));
                        }
                    }
                }

            // add image
            $img = $this->seederHelper->get_random_image('workOrder', 'pool_photo_3' , rand(1, 50));
			Image::create([
				'work_order_id' => $workOrder->id,
				'normal_path' => $img['img_path'],
                'thumbnail_path' => $img['tn_img_path'],
                'icon_path' => $img['xs_img_path'],
				'order' => 1,
                'type' => 1, // Photo before the workOrder has started
			]);

            for ($e=2; $e < rand(3,5); $e++) {
                $img = $this->seederHelper->get_random_image('workOrder', 'pool_photo_1' , rand(1, 50));
    			Image::create([
    				'work_order_id' => $workOrder->id,
    				'normal_path' => $img['img_path'],
                    'thumbnail_path' => $img['tn_img_path'],
                    'icon_path' => $img['xs_img_path'],
    				'order' => $e,
                    'type' => 2, // Photo after the work Order has been finished
    			]);
            }


        }
    }
}
