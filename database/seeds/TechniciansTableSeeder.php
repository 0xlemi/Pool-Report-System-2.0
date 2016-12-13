<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\Image;
use App\Notifications\NewTechnicianNotification;
use App\Technician;
class TechniciansTableSeeder extends Seeder
{
    // number of technicians to create
    private $number_of_technicians = 20;
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
        for ($i=0; $i < $this->number_of_technicians; $i++) {
        	// generate and save image and tn_image
			$img = $this->seederHelper->get_random_image('technician', 20);

            // get a random admin_id that exists in database
            $supervisorId = $this->seederHelper->getRandomObject('supervisors');

    		$technicianId = factory(App\Technician::class)->create([
                'supervisor_id' => $supervisorId,
            ])->id;
            $technician = Technician::findOrFail($technicianId);
            if($this->withNotifications){
                $technician->admin()->user()->notify(new NewTechnicianNotification($technician, $this->seederHelper->getRandomUser($technician->admin(), rand(1,2))));
            }

            factory(App\User::class)->create([
                'email' => 'username_'.rand(100000,999999),
                'password' => bcrypt('password'),
                'userable_id' => $technician->id,
                'userable_type' => 'App\Technician',
            ]);

    		// create images link it to technician
            $technician->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'processing' => 0,
            ]);
        }
    }
}
