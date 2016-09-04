<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\Image;
use App\Equipment;

class EquipmentTableSeeder extends Seeder
{

    private $amount = 100;
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
            $kinds = [
                ['folder' => 'filter', 'name' => 'Filter'],
                ['folder' => 'pump', 'name' => 'Pump'],
                ['folder' => 'comPool', 'name' => 'ComPool'],
                ['folder' => 'heater', 'name' => 'Heater'],
                ['folder' => 'heatPump', 'name' => 'Heat Pump'],
                ['folder' => 'solar', 'name' => 'Solar Panels'],
                ['folder' => 'light', 'name' => 'Light'],
            ];
            $kind = $kinds[rand(0,6)];

		    // generate and save image and tn_image
			$img = $this->seederHelper->get_random_image('equipment', 'equipment/'.$kind['folder'], rand(1, 5));

            // get a random admin_id that exists in database
        	$service_id = $this->seederHelper->get_random_id('services');

    		$equipment_id = factory(Equipment::class)->create([
                'kind' => $kind['name'],
        		'service_id' => $service_id,
            ])->id;

    		// create images link it to equipment id
    		// normal image
    		Image::create([
    			'equipment_id' => $equipment_id,
    			'normal_path' => $img['img_path'],
                'thumbnail_path' => $img['tn_img_path'],
                'icon_path' => $img['xs_img_path'],
    		]);
    	}
    }
}
