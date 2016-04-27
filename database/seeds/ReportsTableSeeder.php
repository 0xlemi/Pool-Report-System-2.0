<?php

use Illuminate\Database\Seeder;
use App\Image;
class ReportsTableSeeder extends Seeder
{
    // number of reports to create
    private $number_of_reports = 300;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < $this->number_of_reports; $i++) { 

    		$report_id = factory(App\Report::class)->create()->id;

    		// create images link it to report
    		for ($e=1; $e <= 3; $e++) {
    			$img = get_random_image('report', 'pool_photo_'.$e , rand(1, 50));

    			// normal image
				Image::create([
					'report_id' => $report_id,
					'path' => $img['img_path'],
					'order' => $e,
				]);
				// thumbnail image
				Image::create([
					'report_id' => $report_id,
					'path' => $img['tn_img_path'],
					'type' => 'T',
					'order' => $e,
				]);
    		}
    	}
    }
}
