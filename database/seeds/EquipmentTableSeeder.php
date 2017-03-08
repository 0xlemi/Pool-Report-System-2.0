<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\Image;
use App\Equipment;
use App\Notifications\AddedEquipmentNotification;
use App\Service;

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
			$img = $this->seederHelper->get_random_image('equipment/'.$kind['folder'], 5);

            // get a random admin_id that exists in database
        	$serviceId = $this->seederHelper->getRandomObject('services');
            $admin = Service::findOrFail($serviceId)->admin();

    		$equipment = factory(Equipment::class)->create([
                'kind' => $kind['name'],
        		'service_id' => $serviceId,
            ]);
            // create images link it to equipment
            $equipment->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'order' => 1,
                'processing' => 0,
            ]);
    	}
    }
}
