<?php

use Illuminate\Database\Seeder;
use App\PRS\Helpers\SeederHelpers;
use App\Image;
class ClientsTableSeeder extends Seeder
{
    // number of clients to create
    private $number_of_clients = 60;
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
			$img = $this->seederHelper->get_random_image('client', 'client/'.$gender, rand(1, 20));

            // get the service id for the pivot table
            $service_id = $this->seederHelper->get_random_id('services');

            // find admin_id congruent with the service
            $admin_id = App\Service::findOrFail($service_id)->admin->id;

    		$client_id = factory(App\Client::class)->create([
                    'admin_id' => $admin_id,
    			])->id;

            factory(App\User::class)->create([
                'name' => $faker->firstName($gender),
                'userable_id' => $client_id,
                'userable_type' => 'Client',
            ]);

            // fill the pivot table that connects with the service
             DB::table('client_service')->insert([
                'client_id' => $client_id,
                'service_id' => $service_id,
            ]);

    		// create images link it to technician
    		Image::create([
    			'client_id' => $client_id,
    			'normal_path' => $img['img_path'],
                'thumbnail_path' => $img['tn_img_path'],
                'icon_path' => $img['xs_img_path'],
    		]);
    	}
    }
}
