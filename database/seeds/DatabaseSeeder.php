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
		'equipment',
		'workOrder',
		'work',
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// cleaning up
    	$this->truncate_tables();

    	$this->call(AdministratorsSeeder::class);
    	$this->call(ServicesTableSeeder::class);
    	$this->call(EquipmentTableSeeder::class);
    	$this->call(SupervisorsTableSeeder::class);
    	$this->call(TechniciansTableSeeder::class);
    	$this->call(ClientsTableSeeder::class);
    	$this->call(WorkOrdersTableSeeder::class);
    	$this->call(WorksTableSeeder::class);
    	$this->call(ReportsTableSeeder::class);
    }


	/**
	 * Cleans the tables
	 */
	protected function truncate_tables(){
		DB::unprepared('SET FOREIGN_KEY_CHECKS = 0;');
		foreach($this->toTruncate as $table){
			DB::table($table)->truncate();
		}
		DB::unprepared('SET FOREIGN_KEY_CHECKS = 1;');
	}

}
