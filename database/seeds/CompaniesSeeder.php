<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Company::flushEventListeners();
        User::flushEventListeners();
        Image::flushEventListeners();

        $admin1 = Company::create([
            'company_name' => 'Hidroequipos',
            'website' => 'www.hidroequipos.com',
            'facebook' => 'poolreportsystem',
            'twitter' => 'poolreportsys',
            'language' => 'en',
    		'timezone' => 'America/Mazatlan',
    	]);

        $admin1->user()->create([
            'email' => 'lem@example.com',
            'password' => bcrypt('password'),
            'activated' => 1,
			'api_token' => 'd8V8NawwkJuxjVz0vcvX4CbljBUsN41mCfHhpDpx0ZOfyU6KfsCKegY154K1',
        ]);

        $admin2 = App\Administrator::create([
    		'name' => 'Pepe Gonzales',
            'company_name' => 'Hidroequipos',
            'website' => 'www.google.com',
            'facebook' => 'poolreportsystem',
            'twitter' => 'poolreportsys',
    		'language' => 'es',
    		'timezone' => 'America/Mazatlan',
    	]);

    	$admin2->user()->create([
    		'email' => 'pepe@example.com',
    		'password' => bcrypt('password'),
            'activated' => 1,
			'api_token' => 'd8V8NawwkJuxjVz0vcvX4CbljBUsN41mCfHhpDpx0ZOfyU6KfsCKegY154K2',
    	]);
    }
}
