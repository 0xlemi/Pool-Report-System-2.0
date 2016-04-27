<?php

use Illuminate\Database\Seeder;
use App\Image;
class ClientsTableSeeder extends Seeder
{
    // number of clients to create
    private $number_of_clients = 60;

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
			$img = get_random_image('client', 'client/'.$gender, rand(1, 20));

            // get the service id for the pivot table
            $service_id = get_random_table_id('services');

            // find user_id congruent with the service
            $user_id = App\Service::findOrFail($service_id)->user->id;

    		$client_id = factory(App\Client::class)->create([
    				'name' => $faker->firstName($gender),
                    'user_id' => $user_id,
    			])->id;

            // fill the pivot table that connects with the service
             DB::table('client_service')->insert([
                'client_id' => $client_id,
                'service_id' => $service_id,
            ]);

    		// create images link it to technician
    		// normal image
    		Image::create([
    			'client_id' => $client_id,
    			'path' => $img['img_path'],
    		]);
    		// thumbnail image
    		Image::create([
    			'client_id' => $client_id,
    			'path' => $img['tn_img_path'],
    			'type' => 'T',
    		]);
            // extra small image
            Image::create([
                'client_id' => $client_id,
                'path' => $img['xs_img_path'],
                'type' => 'S',
            ]);
    	}
    }
}
