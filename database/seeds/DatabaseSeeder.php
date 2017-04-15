<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	protected $toTruncate = [
		'verification_tokens',
		'chemicals',
		'companies',
		'equipment',
		'images',
		'invoices',
		'missing_histories',
		'missing_history_service',
		'notifications',
		'password_resets',
		'payments',
		'permission_role_company',
		'reports',
		'seq',
		'service_contracts',
		'services',
		'subscriptions',
		'urc_notify_setting',
		'urc_service',
		'url_signers',
		'user_role_company',
		'users',
		'work_orders',
		'works'
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

    	$this->call(CompaniesTableSeeder::class);
    	$this->call(ServicesTableSeeder::class);
    	$this->call(UserTableSeeder::class);
    	$this->call(EquipmentTableSeeder::class);
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
