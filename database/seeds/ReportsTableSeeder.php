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
        	$technician_id = $this->seederHelper->get_random_id('technicians');

        	// get the user id in of the random technician
        	$admin_id = Technician::findOrFail($technician_id)->admin()->id;

        	// get a random service that shares the same admin_id
        	// as the technician
        	$service_id = $this->seederHelper->get_random_service($admin_id);

    		$report_id = factory(App\Report::class)->create([
                'service_id' => $service_id,
                'technician_id' => $technician_id,
            ])->id;

    		// create images link it to report
    		for ($e=1; $e <= 3; $e++) {
    			$img = $this->seederHelper->get_random_image('report', 'pool_photo_'.$e , rand(1, 50));

				Image::create([
					'report_id' => $report_id,
					'normal_path' => $img['img_path'],
                    'thumbnail_path' => $img['tn_img_path'],
					'order' => $e,
				]);
    		}
    	}
    }
}
