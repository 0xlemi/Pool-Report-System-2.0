<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\UserRoleCompany;
use App\Image;
use App\Work;

class WorksTableSeeder extends Seeder
{

    private $amount = 2000;
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
        Work::flushEventListeners();
        Image::flushEventListeners();

        for ($i=0; $i < $this->amount; $i++) {
            // Get Random User that is not a client
        	$userRoleCompany = $this->seederHelper->getRandomUserRoleCompany(1, 3, 4);

            // get the user id in of the random technician
        	$company = $userRoleCompany->company;

            $workOrder = $this->seederHelper->getRandomWorkOrder($company);

            $work = factory(Work::class)->create([
                'work_order_id' => $workOrder->id,
                'user_role_company_id' => $userRoleCompany->id,
            ]);

            // add image
            for ($e=1; $e < rand(2,5); $e++) {
                $img = $this->seederHelper->get_random_image('report/3', 50);
                $work->images()->create([
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
