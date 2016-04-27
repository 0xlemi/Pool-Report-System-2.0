<?php

use Illuminate\Database\Seeder;
use App\Image;
class ServicesTableSeeder extends Seeder
{
    // number of services to create
    private $number_of_services = 120;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i < $this->number_of_services; $i++) { 
		    // generate and save image and tn_image
			$img = get_random_image('service', 'service', rand(1, 20));

    		$service_id = factory(App\Service::class)->create()->id;

    		// create images link it to service id
    		// normal image
    		Image::create([
    			'service_id' => $service_id,
    			'path' => $img['img_path'],
    		]);
    		// thumbnail image
    		Image::create([
    			'service_id' => $service_id,
    			'path' => $img['tn_img_path'],
    			'type' => 'T',
    		]);
            // extra small image
            Image::create([
                'service_id' => $service_id,
                'path' => $img['xs_img_path'],
                'type' => 'S',
            ]);
    	}
    }
}
