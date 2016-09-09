<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\Image;
class TechniciansTableSeeder extends Seeder
{
    // number of technicians to create
    private $number_of_technicians = 20;
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
			$img = $this->seederHelper->get_random_image('technician', 'technician', rand(1, 20));

            // get a random admin_id that exists in database
            $supervisorId = $this->seederHelper->getRandomObject('supervisors');

    		$technician = factory(App\Technician::class)->create([
                'supervisor_id' => $supervisorId,
            ]);

            factory(App\User::class)->create([
                'email' => 'username_'.rand(100000,999999),
                'password' => bcrypt('password'),
                'userable_id' => $technician->id,
                'userable_type' => 'App\Technician',
            ]);

    		// create images link it to technician
    		Image::create([
    			'technician_id' => $technician->id,
    			'normal_path' => $img['img_path'],
                'thumbnail_path' => $img['tn_img_path'],
                'icon_path' => $img['xs_img_path'],
    		]);
        }
    }
}
