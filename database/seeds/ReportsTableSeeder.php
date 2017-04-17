<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\UserRoleCompany;
use App\Report;
use App\Image;

use App\Technician;

class ReportsTableSeeder extends Seeder
{
    // number of reports to create
    private $number_of_reports = 800;
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
        Report::flushEventListeners();
        Image::flushEventListeners();

        for ($i=0; $i < $this->number_of_reports; $i++) {
            // Get Random User that is not a client
        	$userRoleCompany = $this->seederHelper->getRandomUserRoleCompany(1, 3, 4);

            // get the user id in of the random technician
        	$company = $userRoleCompany->company;

        	// get a random service that shares the same admin_id
        	// as the technician
        	$service = $this->seederHelper->getRandomService($company);

    		$report = factory(Report::class)->create([
                'service_id' => $service->id,
                'user_role_company_id' => $userRoleCompany->id,
            ]);

            // Add Readings
            for ($a=0; $a < $service->chemicals()->count(); $a++) {
                // Getting a valid and unsed Chemical ID
                $usedChemicals = $report->readings()->pluck('chemical_id')->toArray();
                $chemicalId = $service->chemicals()
                                        ->whereNotIn('chemicals.id', $usedChemicals)
                                        ->get()->random()->id;

                $report->readings()->create([
                    'value' => rand(1, 5),
                    'chemical_id' => $chemicalId
                ]);
            }

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
