<?php

use Illuminate\Database\Seeder;
use App\Company;
use App\UserRoleCompany;
use App\User;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::flushEventListeners();
        User::flushEventListeners();
        UserRoleCompany::flushEventListeners();
        // Image::flushEventListeners();

        $company1 = factory(Company::class)->create([
            'name' => 'Hidroequipos',
            'website' => 'www.hidroequipos.com',
            'facebook' => 'poolreportsystem',
            'twitter' => 'poolreportsys',
            'language' => 'en',
    		'timezone' => 'America/Mazatlan',
    	]);

    	$user1 = factory(User::class)->create([
            'email' => 'lem@example.com',
            'password' => bcrypt('password'),
            'verified' => 1,
			'api_token' => 'd8V8NawwkJuxjVz0vcvX4CbljBUsN41mCfHhpDpx0ZOfyU6KfsCKegY154K1',
        ]);

        $userRoleCompany1 = UserRoleCompany::create([
            'user_id' => $user1->id,
    		'role_id' => 1,
    		'company_id' => $company1->id,
    		'active' => true,
        ]);

        $company2 = factory(Company::class)->create([
            'name' => 'Generic Pool Company',
            'website' => 'www.poolcompany.com',
            'facebook' => 'poolservice',
            'twitter' => 'poolservice',
    		'language' => 'es',
    		'timezone' => 'America/Mazatlan',
    	]);

    	$user2 = factory(User::class)->create([
    		'email' => 'pepe@example.com',
    		'password' => bcrypt('password'),
            'verified' => 1,
			'api_token' => 'd8V8NawwkJuxjVz0vcvX4CbljBUsN41mCfHhpDpx0ZOfyU6KfsCKegY154K2',
    	]);

        $userRoleCompany2 = UserRoleCompany::create([
            'user_id' => $user2->id,
    		'role_id' => 1,
    		'company_id' => $company2->id,
    		'active' => true,
        ]);
    }
}
