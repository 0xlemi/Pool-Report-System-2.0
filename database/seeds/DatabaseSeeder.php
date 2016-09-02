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
    	$this->truncate_tables();
    	$this->delete_in_public_storage();


    	$this->call(AdministratorsSeeder::class);
    	$this->call(ServicesTableSeeder::class);
    	$this->call(EquipmentTableSeeder::class);
    	$this->call(SupervisorsTableSeeder::class);
    	$this->call(TechniciansTableSeeder::class);
    	$this->call(ClientsTableSeeder::class);
    	$this->call(ReportsTableSeeder::class);
    }



	/**
	 * Cleans the tables
	 */
	function truncate_tables(){
		DB::unprepared('SET FOREIGN_KEY_CHECKS = 0;');
		foreach($this->toTruncate as $table){
			DB::table($table)->truncate();
		}
		DB::unprepared('SET FOREIGN_KEY_CHECKS = 1;');
	}

	/**
	 * Cleans old photos by deleting the folder.
	 */
	function delete_in_public_storage(){
		foreach ($this->foldersToDelete as $folder) {
			$files = glob(public_path('storage/images/'.$folder.'/*')); // get all file names
			foreach($files as $file){ // iterate files
			  if(is_file($file))
			    unlink($file); // delete file
			}
		}
	}

}
