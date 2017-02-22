<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\PRS\Classes\Logged;
use App\Image;
use App\Service;
use App\Notifications\NewClientNotification;
use App\Client;

class ClientsTableSeeder extends Seeder
{
    // number of clients to create
    private $number_of_clients = 60;
    private $withNotifications = true;
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
    	$faker = Faker\Factory::create();

        for ($i=0; $i < $this->number_of_clients; $i++) {
        	// woman or men
			$gender = (rand(0,1)) ? 'male':'female';

        	// generate and save image and tn_image
			$img = $this->seederHelper->get_random_image('client/'.$gender, 20);

            // get the service id for the pivot table
            $serviceId = $this->seederHelper->getRandomObject('services');

            // find admin_id congruent with the service
            $admin = Service::findOrFail($serviceId)->admin();

    		$clientId = factory(App\Client::class)->create([
                'name' => $faker->firstName($gender),
                'admin_id' => $admin->id,
    		])->id;
            $client = Client::findOrFail($clientId);
            if($this->withNotifications){
                $admin->user->notify(new NewClientNotification($client, $this->seederHelper->getRandomUser($admin, rand(1,3))));
            }

            factory(App\User::class)->create([
                'userable_id' => $client->id,
                'userable_type' => 'App\Client',
                'activated' => 1,
            ]);

            // fill the pivot table that connects with the service
            DB::table('client_service')->insert([
                'client_id' => $client->id,
                'service_id' => $serviceId,
            ]);

    		// create images link it to client
            $client->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'processing' => 0,
            ]);
    	}
    }
}
