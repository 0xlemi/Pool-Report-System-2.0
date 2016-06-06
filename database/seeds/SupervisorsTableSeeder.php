<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\Image;
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
        for ($i=0; $i < $this->number_of_supervisors; $i++) {
        	// generate and save image and tn_image
    		$img = $this->seederHelper->get_random_image('supervisor', 'supervisor', rand(1, 5));

            // get a random admin_id that exists in database
            // $admin_id = $this->seederHelper->get_random_id('administrators');
            $admin_id = rand(1,2);

    		$supervisor_id = factory(App\Supervisor::class)->create([
        		'admin_id' => $admin_id,
            ])->id;

            factory(App\User::class)->create([
                'userable_id' => $supervisor_id,
                'userable_type' => 'App\Supervisor',
            ]);

    		// create images link it to supervisor
    		Image::create([
    			'supervisor_id' => $supervisor_id,
    			'normal_path' => $img['img_path'],
                'thumbnail_path' => $img['tn_img_path'],
                'icon_path' => $img['xs_img_path'],
    		]);
        }
    }
}
