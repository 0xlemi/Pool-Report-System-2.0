<?php

use Illuminate\Database\Seeder;
use App\UserRoleCompany;
use App\Service;
use App\User;
use App\Image;
use App\PRS\Helpers\SeederHelpers;

class UserTableSeeder extends Seeder
{

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
        $numOfClients = rand(100, 200);
        $numOfSupervisors = rand(10, 20);
        $numOfTechnicians = rand(20, 40);
        $faker = Faker\Factory::create();

        UserRoleCompany::flushEventListeners();
        User::flushEventListeners();
        Image::flushEventListeners();

        for ($i=0; $i < $numOfClients; $i++)
        {
            // woman or men
			$gender = (rand(0,1)) ? 'male':'female';

        	// generate and save image and tn_image
			$img = $this->seederHelper->get_random_image('client/'.$gender, 20);

            // get the service id for the pivot table
            $serviceId = $this->seederHelper->getRandomObject('services');

            // find admin_id congruent with the service
            $company = Service::findOrFail($serviceId)->company;

    		$user = factory(User::class)->create([
                'name' => $faker->firstName($gender),
    		]);

            $userRoleCompany = UserRoleCompany::create([
                'user_id' => $user->id,
                'role_id' => 2,
                'company_id' => $company->id,
            ]);

            // need to attach this user to some services
            $userRoleCompany->services()->attach($serviceId);

            // create images link it to client
            $user->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'processing' => 0,
            ]);
        }

        for ($i=0; $i < $numOfSupervisors; $i++)
        {
            // generate and save image and tn_image
    		$img = $this->seederHelper->get_random_image('supervisor', 5);

            // get a random company_id that exists in database
            $company_id = rand(1,2);

    		$user = factory(User::class)->create();

            UserRoleCompany::create([
                'user_id' => $user->id,
                'role_id' => 3,
                'company_id' => $company_id,
            ]);

            // create images link it to supervisors
            $user->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'processing' => 0,
            ]);

        }

        for ($i=0; $i < $numOfTechnicians; $i++)
        {
            // generate and save image and tn_image
			$img = $this->seederHelper->get_random_image('technician', 20);

            // get a random company_id that exists in database
            $company_id = rand(1,2);

    		$user = factory(User::class)->create();

            UserRoleCompany::create([
                'user_id' => $user->id,
                'role_id' => 4,
                'company_id' => $company_id,
            ]);

    		// create images link it to technician
            $user->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'processing' => 0,
            ]);
        }
    }
}
