<?php

use Illuminate\Database\Seeder;
class AdministratorsSeeder extends Seeder
{

    protected $number_of_administrators = 2;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for ($i=0; $i < $this->number_of_administrators; $i++) {
        //
    	// 	$administrator_id = factory(App\Administrator::class)->create()->id;
        //
        //     factory(App\User::class)->create([
        //         'userable_id' => $administrator_id,
        //         'userable_type' => 'Administrator',
        //     ]);
        //
        // }
        $administrator_id = App\Administrator::create([
            'company_name' => 'Hidroequipos',
            'website' => 'www.hidroequipos.com',
            'facebook' => 'poolreportsystem',
            'twitter' => 'poolreportsys',
    		'timezone' => 'America/Mazatlan',
    	])->id;

        App\User::create([
            'name' => 'Luis Espinosa',
            'email' => 'lem.espinosa.m@gmail.com',
            'password' => bcrypt('password'),
            'language' => 'en',
			'api_token' => 'd8V8NawwkJuxjVz0vcvX4CbljBUsN41mCfHhpDpx0ZOfyU6KfsCKegY154K1',
            'userable_id' => $administrator_id,
            'userable_type' => 'App\Administrator',
        ]);

        $administrator_id = App\Administrator::create([
            'company_name' => 'Hidroequipos',
            'website' => 'www.google.com',
            'facebook' => 'poolreportsystem',
            'twitter' => 'poolreportsys',
    		'timezone' => 'America/Mazatlan',
    	])->id;

    	App\User::create([
    		'name' => 'Pepe Gonzales',
    		'email' => 'pepe@example.com',
    		'password' => bcrypt('password'),
    		'language' => 'es',
			'api_token' => 'd8V8NawwkJuxjVz0vcvX4CbljBUsN41mCfHhpDpx0ZOfyU6KfsCKegY154K2',
            'userable_id' => $administrator_id,
            'userable_type' => 'App\Administrator',
    	]);
    }
}
