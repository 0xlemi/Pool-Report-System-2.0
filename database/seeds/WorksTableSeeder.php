<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\Technician;

use App\Image;
use App\Work;

class WorksTableSeeder extends Seeder
{

    private $amount = 300;
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

        	$technicianId = $this->seederHelper->getRandomObject('technicians');

            $admin = Technician::findOrFail($technicianId)->admin();

            $workOrder = $this->seederHelper->getRandomWorkOrder($admin);

            $workId = factory(App\Work::class)->create([
                'work_order_id' => $workOrder->id,
                'technician_id' => $technicianId,
            ])->id;

            // add image
            for ($e=0; $e < rand(0,3); $e++) {
            $img = $this->seederHelper->get_random_image('work', 'pool_photo_3' , rand(1, 50));
    			Image::create([
    				'work_id' => $workId,
    				'normal_path' => $img['img_path'],
                    'thumbnail_path' => $img['tn_img_path'],
    				'order' => $e,
    			]);
            }

        }
    }
}
