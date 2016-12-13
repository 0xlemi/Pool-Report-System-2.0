<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\Technician;

use App\Image;
use App\Work;
use App\Notifications\AddedWorkNotification;

class WorksTableSeeder extends Seeder
{

    private $amount = 300;
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

        	$technicianId = $this->seederHelper->getRandomObject('technicians');

            $admin = Technician::findOrFail($technicianId)->admin();

            $workOrder = $this->seederHelper->getRandomWorkOrder($admin);

            $workId = factory(App\Work::class)->create([
                'work_order_id' => $workOrder->id,
                'technician_id' => $technicianId,
            ])->id;
            $work = Work::findOrFail($workId);
            if($this->withNotifications){
                $admin->user()->notify(new AddedWorkNotification($work, $this->seederHelper->getRandomUser($admin, rand(1,4))));
            }

            // add image
            for ($e=0; $e < rand(1,4); $e++) {
            $img = $this->seederHelper->get_random_image('report/3', 50);
                $work->images()->create([
    				'big' => $img->big,
                    'medium' => $img->medium,
                    'thumbnail' => $img->thumbnail,
                    'icon' => $img->icon,
    				'order' => $e,
                    'processing' => 0,
    			]);
            }

        }
    }
}
