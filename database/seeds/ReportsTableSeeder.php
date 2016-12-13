<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\Image;

use App\Technician;

class ReportsTableSeeder extends Seeder
{
    // number of reports to create
    private $number_of_reports = 200;
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
        for ($i=0; $i < $this->number_of_reports; $i++) {

            // random technician id
        	$technicianId = $this->seederHelper->getRandomObject('technicians');

        	// get the user id in of the random technician
        	$admin = Technician::findOrFail($technicianId)->admin();

        	// get a random service that shares the same admin_id
        	// as the technician
        	$service = $this->seederHelper->getRandomService($admin);

    		$report = factory(App\Report::class)->create([
                'service_id' => $service->id,
                'technician_id' => $technicianId,
            ]);

    		// create images link it to report
    		for ($e=1; $e <= 3; $e++) {
    			$img = $this->seederHelper->get_random_image("report/{$e}", 50);
                $report->images()->create([
					'big' => $img->big,
                    'medium' => $img->medium,
                    'thumbnail' => $img->thumbnail,
                    'icon' => $img->icon,
					'order' => $e,
                    'processing' => 0,
				]);
    		}
    	}
    }
}
