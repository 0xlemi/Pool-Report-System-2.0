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
    		'language' => 'en',
    		'timezone' => 'America/Mazatlan'

    	]);
    	$this->call(ServicesTableSeeder::class);
    	$this->call(SupervisorsTableSeeder::class);
    	$this->call(TechniciansTableSeeder::class);
    	$this->call(ClientsTableSeeder::class);
    	$this->call(ReportsTableSeeder::class);
    }
}
