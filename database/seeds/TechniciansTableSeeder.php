<?php

use Illuminate\Database\Seeder;
use App\Image;
class TechniciansTableSeeder extends Seeder
{
    // number of technicians to create
    private $number_of_technicians = 30;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < $this->number_of_technicians; $i++) { 
        	// generate and save image and tn_image
			$img = get_random_image('technician', 'technician', rand(1, 20));

    		$technician_id = factory(App\Technician::class)->create()->id;

    		// create images link it to technician
    		Image::create([
    			'technician_id' => $technician_id,
    			'normal_path' => $img['img_path'],
                'thumbnail_path' => $img['tn_img_path'],
                'icon_path' => $img['xs_img_path'],
    		]);
        }
    }
}
