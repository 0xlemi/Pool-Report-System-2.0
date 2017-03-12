<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\Image;
use App\Notifications\NewSupervisorNotification;
use App\Administrator;
use App\Supervisor;
use App\User;
class SupervisorsTableSeeder extends Seeder
{
    // number of supervisors to create
    private $number_of_supervisors = 6;
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
        Supervisor::flushEventListeners();
        User::flushEventListeners();
        Image::flushEventListeners();

        for ($i=0; $i < $this->number_of_supervisors; $i++) {
        	// generate and save image and tn_image
    		$img = $this->seederHelper->get_random_image('supervisor', 5);

            // get a random admin_id that exists in database
            $adminId = rand(1,2);

    		$supervisor = factory(App\Supervisor::class)->create([
        		'admin_id' => $adminId,
            ]);
            // create images link it to supervisors
            $supervisor->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'processing' => 0,
            ]);

            factory(App\User::class)->create([
                'password' => bcrypt('password'),
                'userable_id' => $supervisor->id,
                'userable_type' => 'App\Supervisor',
                'activated' => 1,
            ]);

        }
    }
}
