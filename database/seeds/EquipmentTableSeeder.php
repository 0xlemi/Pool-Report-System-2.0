<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;

class EquipmentTableSeeder extends Seeder
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
		    // generate and save image and tn_image
			// $img = $this->seederHelper->get_random_image('service', 'service', rand(1, 20));

            // get a random admin_id that exists in database
        	$service_id = $this->seederHelper->get_random_id('services');

    		$equipment_id = factory(App\Equipment::class)->create([
        		'service_id' => $service_id,
            ])->id;
            //
    		// // create images link it to service id
    		// // normal image
    		// Image::create([
    		// 	'service_id' => $service_id,
    		// 	'normal_path' => $img['img_path'],
            //     'thumbnail_path' => $img['tn_img_path'],
            //     'icon_path' => $img['xs_img_path'],
    		// ]);
    	}
    }
}
