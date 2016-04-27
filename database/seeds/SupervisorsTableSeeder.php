<?php

use Illuminate\Database\Seeder;
use App\Image;
class SupervisorsTableSeeder extends Seeder
{
    // number of supervisors to create
    private $number_of_supervisors = 6;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < $this->number_of_supervisors; $i++) { 
        	// generate and save image and tn_image
    		$img = get_random_image('supervisor', 'supervisor', rand(1, 5));

    		$supervisor_id = factory(App\Supervisor::class)->create()->id;

    		// create images link it to supervisor
    		// normal image
    		Image::create([
    			'supervisor_id' => $supervisor_id,
    			'path' => $img['img_path'],
    		]);
    		// thumbnail image
    		Image::create([
    			'supervisor_id' => $supervisor_id,
    			'path' => $img['tn_img_path'],
    			'type' => 'T',
    		]);
            // extra small image
            Image::create([
                'supervisor_id' => $supervisor_id,
                'path' => $img['xs_img_path'],
                'type' => 'S',
            ]);
        }
    }
}
