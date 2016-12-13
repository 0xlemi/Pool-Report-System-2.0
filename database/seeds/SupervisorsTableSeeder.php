<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\Image;
use App\Notifications\NewSupervisorNotification;
use App\Administrator;
use App\Supervisor;
class SupervisorsTableSeeder extends Seeder
{
    // number of supervisors to create
    private $number_of_supervisors = 6;
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
        for ($i=0; $i < $this->number_of_supervisors; $i++) {
        	// generate and save image and tn_image
    		$img = $this->seederHelper->get_random_image('supervisor', 5);

            // get a random admin_id that exists in database
            // $adminId = $this->seederHelper->getRandomObject('administrators');
            $adminId = rand(1,2);

    		$supervisorId = factory(App\Supervisor::class)->create([
        		'admin_id' => $adminId,
            ])->id;
            $admin = Administrator::findOrFail($adminId);

            $supervisor = Supervisor::findOrFail($supervisorId);
            if($this->withNotifications){
                $admin->user()->notify(new NewSupervisorNotification($supervisor, $admin->user()));
            }

            factory(App\User::class)->create([
                'password' => bcrypt('password'),
                'userable_id' => $supervisor->id,
                'userable_type' => 'App\Supervisor',
            ]);

    		// create images link it to supervisors
            $supervisor->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'processing' => 0,
            ]);
        }
    }
}
