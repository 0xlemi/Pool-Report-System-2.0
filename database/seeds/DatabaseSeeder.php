<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	protected $toTruncate = [
		'images',
		'chat',
		'reports',
		'client_service',
		'clients',
		'technicians',
		'supervisors',
		'services',
		'seq',
		'users',
	];

	protected $foldersToDelete = [
		'client',
		'report',
		'service',
		'supervisor',
		'technician',
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// cleaning up
    	truncate_tables($this->toTruncate);
    	delete_in_public_storage($this->foldersToDelete);

    	App\User::create([
    		'name' => 'Luis Espinosa',
    		'email' => 'lem.espinosa.m@gmail.com',
    		'password' => bcrypt('password'),
        'company_name' => 'Hidroequipos',
        'website' => 'www.hidroequipos.com',
        'facebook' => 'poolreportsystem',
        'twitter' => 'poolreportsys',
    		'language' => 'en',
    		'timezone' => 'America/Mazatlan',
				'api_token' => 'd8V8NawwkJuxjVz0vcvX4CbljBUsN41mCfHhpDpx0ZOfyU6KfsCKegY154K1',
    	]);
    	App\User::create([
    		'name' => 'Pepe Gonzales',
    		'email' => 'pepe@example.com',
    		'password' => bcrypt('password'),
        'company_name' => 'Hidroequipos',
        'website' => 'www.google.com',
        'facebook' => 'poolreportsystem',
        'twitter' => 'poolreportsys',
    		'language' => 'es',
    		'timezone' => 'America/Mazatlan',
				'api_token' => 'd8V8NawwkJuxjVz0vcvX4CbljBUsN41mCfHhpDpx0ZOfyU6KfsCKegY154K2',
    	]);
    	$this->call(ServicesTableSeeder::class);
    	$this->call(SupervisorsTableSeeder::class);
    	$this->call(TechniciansTableSeeder::class);
    	$this->call(ClientsTableSeeder::class);
    	$this->call(ReportsTableSeeder::class);
    }
}
