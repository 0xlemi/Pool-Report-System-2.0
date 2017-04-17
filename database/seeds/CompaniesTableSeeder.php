<?php

use Illuminate\Database\Seeder;
use App\Company;
use App\Chemical;
use App\GlobalChemical;
use App\UserRoleCompany;
use App\User;
use App\Label;

class CompaniesTableSeeder extends Seeder
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
        Chemical::flushEventListeners();
        GlobalChemical::flushEventListeners();
        Label::flushEventListeners();
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
            'name' => 'Luis',
            'last_name' => 'Espinosa',
            'email' => 'lem@example.com',
            'password' => bcrypt('password'),
            'verified' => 1,
			// 'api_token' => 'd8V8NawwkJuxjVz0vcvX4CbljBUsN41mCfHhpDpx0ZOfyU6KfsCKegY154K1',
        ]);

        $userRoleCompany1 = factory(UserRoleCompany::class)->create([
            'user_id' => $user1->id,
    		'role_id' => 1,
    		'company_id' => $company1->id,
    		'selected' => true,
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
            'name' => 'Pepe',
            'last_name' => 'Gonzales',
    		'email' => 'pepe@example.com',
    		'password' => bcrypt('password'),
            'verified' => 1,
			// 'api_token' => 'd8V8NawwkJuxjVz0vcvX4CbljBUsN41mCfHhpDpx0ZOfyU6KfsCKegY154K2',
    	]);

        $userRoleCompany2 = factory(UserRoleCompany::class)->create([
            'user_id' => $user2->id,
    		'role_id' => 1,
    		'company_id' => $company2->id,
    		'selected' => true,
        ]);


        // Make Other UserRoleCompany on the same user to test changeURC Functionality
        $urcOwnCompanyClient1 = factory(UserRoleCompany::class)->create([
            'user_id' => $user1->id,
    		'role_id' => 2,
    		'company_id' => $company1->id,
    		'selected' => false,
        ]);
        $urcOtherCompanySupervisor1 = factory(UserRoleCompany::class)->create([
            'user_id' => $user1->id,
    		'role_id' => 3,
    		'company_id' => $company2->id,
    		'selected' => false,
        ]);
        $urcOwnCompanyClient2 = factory(UserRoleCompany::class)->create([
            'user_id' => $user2->id,
    		'role_id' => 2,
    		'company_id' => $company2->id,
    		'selected' => false,
        ]);
        $urcOtherCompanyTechnician2 = factory(UserRoleCompany::class)->create([
            'user_id' => $user2->id,
    		'role_id' => 4,
    		'company_id' => $company1->id,
    		'selected' => false,
        ]);

        // ***************************
        //   Create Global Chemicals
        // ***************************

        $chlorine1 = $company1->globalChemicals()->create([
            'name' =>  'Chlorine',
            'units' => 'Grams'
        ]);
            $chlorine1->labels()->create([
                'name' => '0.6 PPM',
                'value' => 1
            ]);
            $chlorine1->labels()->create([
                'name' => '1.0 PPM',
                'value' => 2
            ]);
            $chlorine1->labels()->create([
                'name' => '1.5 PPM',
                'value' => 3
            ]);
            $chlorine1->labels()->create([
                'name' => '2.0 PPM',
                'value' => 4
            ]);
            $chlorine1->labels()->create([
                'name' => '3.0 PPM',
                'value' => 5
            ]);
        $ph1 = $company1->globalChemicals()->create([
            'name' =>  'PH Adjuster',
            'units' => 'Grams'
        ]);
            $ph1->labels()->create([
                'name' => '6.8 pH',
                'value' => 1
            ]);
            $ph1->labels()->create([
                'name' => '7.2 pH',
                'value' => 2
            ]);
            $ph1->labels()->create([
                'name' => '7.5 pH',
                'value' => 3
            ]);
            $ph1->labels()->create([
                'name' => '7.8 pH',
                'value' => 4
            ]);
            $ph1->labels()->create([
                'name' => '8.2 pH',
                'value' => 5
            ]);
        $salt1 = $company1->globalChemicals()->create([
            'name' =>  'Salt',
            'units' => 'PPM'
        ]);
            $salt1->labels()->create([
                'name' => 'Very Low',
                'value' => 1
            ]);
            $salt1->labels()->create([
                'name' => 'Low',
                'value' => 2
            ]);
            $salt1->labels()->create([
                'name' => 'Perfect',
                'value' => 3
            ]);
            $salt1->labels()->create([
                'name' => 'High',
                'value' => 4
            ]);
            $salt1->labels()->create([
                'name' => 'Very High',
                'value' => 5
            ]);

        $chlorine2 = $company2->globalChemicals()->create([
            'name' =>  'Chlorine',
            'units' => 'Grams'
        ]);
            $chlorine2->labels()->create([
                'name' => '0.6 PPM',
                'value' => 1
            ]);
            $chlorine2->labels()->create([
                'name' => '1.0 PPM',
                'value' => 2
            ]);
            $chlorine2->labels()->create([
                'name' => '1.5 PPM',
                'value' => 3
            ]);
            $chlorine2->labels()->create([
                'name' => '2.0 PPM',
                'value' => 4
            ]);
            $chlorine2->labels()->create([
                'name' => '3.0 PPM',
                'value' => 5
            ]);

        $ph2 = $company2->globalChemicals()->create([
            'name' =>  'PH Adjuster',
            'units' => 'Grams'
        ]);
            $ph2->labels()->create([
                'name' => '6.8 pH',
                'value' => 1
            ]);
            $ph2->labels()->create([
                'name' => '7.2 pH',
                'value' => 2
            ]);
            $ph2->labels()->create([
                'name' => '7.5 pH',
                'value' => 3
            ]);
            $ph2->labels()->create([
                'name' => '7.8 pH',
                'value' => 4
            ]);
            $ph2->labels()->create([
                'name' => '8.2 pH',
                'value' => 5
            ]);

        $salt2 = $company2->globalChemicals()->create([
            'name' =>  'Salt',
            'units' => 'PPM'
        ]);
            $salt2->labels()->create([
                'name' => 'Very Low',
                'value' => 1
            ]);
            $salt2->labels()->create([
                'name' => 'Low',
                'value' => 2
            ]);
            $salt2->labels()->create([
                'name' => 'Perfect',
                'value' => 3
            ]);
            $salt2->labels()->create([
                'name' => 'High',
                'value' => 4
            ]);
            $salt2->labels()->create([
                'name' => 'Very High',
                'value' => 5
            ]);


        // Notification Settings
        DB::table('urc_notify_setting')->insert([
            [ 'notify_setting_id' => 1, 'urc_id' => $userRoleCompany1->id ],// Notification when Report is Created
            [ 'notify_setting_id' => 2, 'urc_id' => $userRoleCompany1->id ],// Notification when Work Order is Created
            [ 'notify_setting_id' => 3, 'urc_id' => $userRoleCompany1->id ],// Notification when Service is Created
            [ 'notify_setting_id' => 4, 'urc_id' => $userRoleCompany1->id ],// Notification when Client is Created
            [ 'notify_setting_id' => 5, 'urc_id' => $userRoleCompany1->id ],// Notification when Supervisor is Created
            [ 'notify_setting_id' => 6, 'urc_id' => $userRoleCompany1->id ],// Notification when Technician is Created
            [ 'notify_setting_id' => 7, 'urc_id' => $userRoleCompany1->id ],// Notification when Invoice is Created
            [ 'notify_setting_id' => 8, 'urc_id' => $userRoleCompany1->id ],// Notification when Payment is Created
            [ 'notify_setting_id' => 9, 'urc_id' => $userRoleCompany1->id ],// Notification when Work is added to Work Order
            [ 'notify_setting_id' => 10, 'urc_id' => $userRoleCompany1->id ],// Notification when Chemical is added to Service
            [ 'notify_setting_id' => 11, 'urc_id' => $userRoleCompany1->id ],// Notification when Equipment is added to Service
            [ 'notify_setting_id' => 12, 'urc_id' => $userRoleCompany1->id ],// Notification when Contract is added to Service
            [ 'notify_setting_id' => 13, 'urc_id' => $userRoleCompany1->id ],// Email when Report is Created
            [ 'notify_setting_id' => 14, 'urc_id' => $userRoleCompany1->id ],// Email when Work Order is Created
            [ 'notify_setting_id' => 15, 'urc_id' => $userRoleCompany1->id ],// Email when Service is Created
            [ 'notify_setting_id' => 16, 'urc_id' => $userRoleCompany1->id ],// Email when Client is Created
            [ 'notify_setting_id' => 17, 'urc_id' => $userRoleCompany1->id ],// Email when Supervisor is Created
            [ 'notify_setting_id' => 18, 'urc_id' => $userRoleCompany1->id ],// Email when Technician is Created
            [ 'notify_setting_id' => 19, 'urc_id' => $userRoleCompany1->id ],// Email when Invoice is Created
            [ 'notify_setting_id' => 20, 'urc_id' => $userRoleCompany1->id ],// Email when Payment is Created

            [ 'notify_setting_id' => 1, 'urc_id' => $userRoleCompany2->id ],// Notification when Report is Created
            [ 'notify_setting_id' => 2, 'urc_id' => $userRoleCompany2->id ],// Notification when Work Order is Created
            [ 'notify_setting_id' => 3, 'urc_id' => $userRoleCompany2->id ],// Notification when Service is Created
            [ 'notify_setting_id' => 4, 'urc_id' => $userRoleCompany2->id ],// Notification when Client is Created
            [ 'notify_setting_id' => 5, 'urc_id' => $userRoleCompany2->id ],// Notification when Supervisor is Created
            [ 'notify_setting_id' => 6, 'urc_id' => $userRoleCompany2->id ],// Notification when Technician is Created
            [ 'notify_setting_id' => 7, 'urc_id' => $userRoleCompany2->id ],// Notification when Invoice is Created
            [ 'notify_setting_id' => 8, 'urc_id' => $userRoleCompany2->id ],// Notification when Payment is Created
            [ 'notify_setting_id' => 9, 'urc_id' => $userRoleCompany2->id ],// Notification when Work is added to Work Order
            [ 'notify_setting_id' => 10, 'urc_id' => $userRoleCompany2->id ],// Notification when Chemical is added to Service
            [ 'notify_setting_id' => 11, 'urc_id' => $userRoleCompany2->id ],// Notification when Equipment is added to Service
            [ 'notify_setting_id' => 12, 'urc_id' => $userRoleCompany2->id ],// Notification when Contract is added to Service
            [ 'notify_setting_id' => 13, 'urc_id' => $userRoleCompany2->id ],// Email when Report is Created
            [ 'notify_setting_id' => 14, 'urc_id' => $userRoleCompany2->id ],// Email when Work Order is Created
            [ 'notify_setting_id' => 15, 'urc_id' => $userRoleCompany2->id ],// Email when Service is Created
            [ 'notify_setting_id' => 16, 'urc_id' => $userRoleCompany2->id ],// Email when Client is Created
            [ 'notify_setting_id' => 17, 'urc_id' => $userRoleCompany2->id ],// Email when Supervisor is Created
            [ 'notify_setting_id' => 18, 'urc_id' => $userRoleCompany2->id ],// Email when Technician is Created
            [ 'notify_setting_id' => 19, 'urc_id' => $userRoleCompany2->id ],// Email when Invoice is Created
            [ 'notify_setting_id' => 20, 'urc_id' => $userRoleCompany2->id ],// Email when Payment is Created
        ]);

        // Permissions for companies
        DB::table('permission_role_company')->insert([
            // Supervisor
            ['role_id' => 3, 'permission_id' => 1, 'company_id' => 1],// Show Reports
            ['role_id' => 3, 'permission_id' => 2, 'company_id' => 1],// Create New Report
            ['role_id' => 3, 'permission_id' => 3, 'company_id' => 1],// Edit Reports
            ['role_id' => 3, 'permission_id' => 4, 'company_id' => 1],// Add Photos for Reports
            ['role_id' => 3, 'permission_id' => 5, 'company_id' => 1],// Remove Photos for Reports
            ['role_id' => 3, 'permission_id' => 6, 'company_id' => 1],// Delete Report
            ['role_id' => 3, 'permission_id' => 7, 'company_id' => 1],// Show Work Orders
            ['role_id' => 3, 'permission_id' => 8, 'company_id' => 1],// Create New Work Order
            ['role_id' => 3, 'permission_id' => 9, 'company_id' => 1],// Edit Work Orders
            ['role_id' => 3 ,'permission_id' => 10, 'company_id' => 1 ],// Finish Work Orders
            ['role_id' => 3 ,'permission_id' => 11, 'company_id' => 1 ],// Add Before Photos for Work Orders
            ['role_id' => 3 ,'permission_id' => 12, 'company_id' => 1 ],// Remove Photos for Work Orders
            ['role_id' => 3 ,'permission_id' => 13, 'company_id' => 1 ],// Delete Work Orders
            ['role_id' => 3 ,'permission_id' => 14, 'company_id' => 1 ],// Show Works
            ['role_id' => 3 ,'permission_id' => 15, 'company_id' => 1 ],// Create New Work
            ['role_id' => 3 ,'permission_id' => 16, 'company_id' => 1 ],// Edit Work
            ['role_id' => 3 ,'permission_id' => 17, 'company_id' => 1 ],// Add Before Photos for Work
            ['role_id' => 3 ,'permission_id' => 18, 'company_id' => 1 ],// Remove Before Photos for Work
            ['role_id' => 3 ,'permission_id' => 19, 'company_id' => 1 ],// Delete Work
            ['role_id' => 3 ,'permission_id' => 20, 'company_id' => 1 ],// Show Services
            ['role_id' => 3 ,'permission_id' => 21, 'company_id' => 1 ],// Create New Service
            ['role_id' => 3 ,'permission_id' => 22, 'company_id' => 1 ],// Edit Services
            ['role_id' => 3 ,'permission_id' => 23, 'company_id' => 1 ],// Delete Service
            ['role_id' => 3 ,'permission_id' => 24, 'company_id' => 1 ],// Show Contract
            ['role_id' => 3 ,'permission_id' => 25, 'company_id' => 1 ],// Create New Contract
            ['role_id' => 3 ,'permission_id' => 26, 'company_id' => 1 ],// Edit Contract
            ['role_id' => 3 ,'permission_id' => 27, 'company_id' => 1 ],// Toggle Contract Activation
            ['role_id' => 3 ,'permission_id' => 29, 'company_id' => 1 ],// Show Chemicals
            ['role_id' => 3 ,'permission_id' => 30, 'company_id' => 1 ],// Create New Chemical
            ['role_id' => 3 ,'permission_id' => 31, 'company_id' => 1 ],// Edit Chemicals
            ['role_id' => 3 ,'permission_id' => 32, 'company_id' => 1 ],// Delete Chemical
            ['role_id' => 3 ,'permission_id' => 33, 'company_id' => 1 ],// Show Equipment
            ['role_id' => 3 ,'permission_id' => 34, 'company_id' => 1 ],// Create New Equipment
            ['role_id' => 3 ,'permission_id' => 35, 'company_id' => 1 ],// Edit Equipment
            ['role_id' => 3 ,'permission_id' => 36, 'company_id' => 1 ],// Add Photos for Equipment
            ['role_id' => 3 ,'permission_id' => 37, 'company_id' => 1 ],// Remove Photos for Equipment
            ['role_id' => 3 ,'permission_id' => 38, 'company_id' => 1 ],// Delete Equipment
            ['role_id' => 3 ,'permission_id' => 39, 'company_id' => 1 ],// Show Clients
            ['role_id' => 3 ,'permission_id' => 40, 'company_id' => 1 ],// Create New Client
            ['role_id' => 3 ,'permission_id' => 41, 'company_id' => 1 ],// Edit Clients
            ['role_id' => 3 ,'permission_id' => 42, 'company_id' => 1 ],// Delete Client
            ['role_id' => 3 ,'permission_id' => 43, 'company_id' => 1 ],// Show Supervisor
            ['role_id' => 3 ,'permission_id' => 44, 'company_id' => 1 ],// Create New Supervisor
            ['role_id' => 3 ,'permission_id' => 47, 'company_id' => 1 ],// Show Technicians
            ['role_id' => 3 ,'permission_id' => 48, 'company_id' => 1 ],// Create New Technician
            ['role_id' => 3 ,'permission_id' => 49, 'company_id' => 1 ],// Edit Technicians
            ['role_id' => 3 ,'permission_id' => 50, 'company_id' => 1 ],// Delete Technician
            ['role_id' => 3 ,'permission_id' => 51, 'company_id' => 1 ],// Show Invoices
            ['role_id' => 3 ,'permission_id' => 53, 'company_id' => 1 ],// Create New Payment
            ['role_id' => 3 ,'permission_id' => 54, 'company_id' => 1 ],// Show Payments

            // Technician
            ['role_id' => 4, 'permission_id' => 1, 'company_id' => 1],// Show Reports
            ['role_id' => 4, 'permission_id' => 2, 'company_id' => 1],// Create New Report
            ['role_id' => 4, 'permission_id' => 7, 'company_id' => 1],// Show Work Orders
            ['role_id' => 4, 'permission_id' => 8, 'company_id' => 1],// Create New Work Order
            ['role_id' => 4 ,'permission_id' => 10, 'company_id' => 1 ],// Finish Work Orders
            ['role_id' => 4 ,'permission_id' => 14, 'company_id' => 1 ],// Show Works
            ['role_id' => 4 ,'permission_id' => 15, 'company_id' => 1 ],// Create New Work
            ['role_id' => 4 ,'permission_id' => 17, 'company_id' => 1 ],// Add Before Photos for Work
            ['role_id' => 4 ,'permission_id' => 20, 'company_id' => 1 ],// Show Services
            ['role_id' => 4 ,'permission_id' => 29, 'company_id' => 1 ],// Show Chemicals
            ['role_id' => 4 ,'permission_id' => 30, 'company_id' => 1 ],// Create New Chemical
            ['role_id' => 4 ,'permission_id' => 33, 'company_id' => 1 ],// Show Equipment
            ['role_id' => 4 ,'permission_id' => 34, 'company_id' => 1 ],// Create New Equipment
            ['role_id' => 4 ,'permission_id' => 36, 'company_id' => 1 ],// Add Photos for Equipment
            ['role_id' => 4 ,'permission_id' => 43, 'company_id' => 1 ],// Show Supervisor
        ]);

        DB::table('permission_role_company')->insert([
            // Supervisor
            ['role_id' => 3, 'permission_id' => 1, 'company_id' => 2],// Show Reports
            ['role_id' => 3, 'permission_id' => 2, 'company_id' => 2],// Create New Report
            ['role_id' => 3, 'permission_id' => 3, 'company_id' => 2],// Edit Reports
            ['role_id' => 3, 'permission_id' => 4, 'company_id' => 2],// Add Photos for Reports
            ['role_id' => 3, 'permission_id' => 5, 'company_id' => 2],// Remove Photos for Reports
            ['role_id' => 3, 'permission_id' => 6, 'company_id' => 2],// Delete Report
            ['role_id' => 3, 'permission_id' => 7, 'company_id' => 2],// Show Work Orders
            ['role_id' => 3, 'permission_id' => 8, 'company_id' => 2],// Create New Work Order
            ['role_id' => 3, 'permission_id' => 9, 'company_id' => 2],// Edit Work Orders
            ['role_id' => 3 ,'permission_id' => 10, 'company_id' => 2 ],// Finish Work Orders
            ['role_id' => 3 ,'permission_id' => 11, 'company_id' => 2 ],// Add Before Photos for Work Orders
            ['role_id' => 3 ,'permission_id' => 12, 'company_id' => 2 ],// Remove Photos for Work Orders
            ['role_id' => 3 ,'permission_id' => 13, 'company_id' => 2 ],// Delete Work Orders
            ['role_id' => 3 ,'permission_id' => 14, 'company_id' => 2 ],// Show Works
            ['role_id' => 3 ,'permission_id' => 15, 'company_id' => 2 ],// Create New Work
            ['role_id' => 3 ,'permission_id' => 16, 'company_id' => 2 ],// Edit Work
            ['role_id' => 3 ,'permission_id' => 17, 'company_id' => 2 ],// Add Before Photos for Work
            ['role_id' => 3 ,'permission_id' => 18, 'company_id' => 2 ],// Remove Before Photos for Work
            ['role_id' => 3 ,'permission_id' => 19, 'company_id' => 2 ],// Delete Work
            ['role_id' => 3 ,'permission_id' => 20, 'company_id' => 2 ],// Show Services
            ['role_id' => 3 ,'permission_id' => 21, 'company_id' => 2 ],// Create New Service
            ['role_id' => 3 ,'permission_id' => 22, 'company_id' => 2 ],// Edit Services
            ['role_id' => 3 ,'permission_id' => 23, 'company_id' => 2 ],// Delete Service
            ['role_id' => 3 ,'permission_id' => 24, 'company_id' => 2 ],// Show Contract
            ['role_id' => 3 ,'permission_id' => 25, 'company_id' => 2 ],// Create New Contract
            ['role_id' => 3 ,'permission_id' => 26, 'company_id' => 2 ],// Edit Contract
            ['role_id' => 3 ,'permission_id' => 27, 'company_id' => 2 ],// Toggle Contract Activation
            ['role_id' => 3 ,'permission_id' => 29, 'company_id' => 2 ],// Show Chemicals
            ['role_id' => 3 ,'permission_id' => 30, 'company_id' => 2 ],// Create New Chemical
            ['role_id' => 3 ,'permission_id' => 31, 'company_id' => 2 ],// Edit Chemicals
            ['role_id' => 3 ,'permission_id' => 32, 'company_id' => 2 ],// Delete Chemical
            ['role_id' => 3 ,'permission_id' => 33, 'company_id' => 2 ],// Show Equipment
            ['role_id' => 3 ,'permission_id' => 34, 'company_id' => 2 ],// Create New Equipment
            ['role_id' => 3 ,'permission_id' => 35, 'company_id' => 2 ],// Edit Equipment
            ['role_id' => 3 ,'permission_id' => 36, 'company_id' => 2 ],// Add Photos for Equipment
            ['role_id' => 3 ,'permission_id' => 37, 'company_id' => 2 ],// Remove Photos for Equipment
            ['role_id' => 3 ,'permission_id' => 38, 'company_id' => 2 ],// Delete Equipment
            ['role_id' => 3 ,'permission_id' => 39, 'company_id' => 2 ],// Show Clients
            ['role_id' => 3 ,'permission_id' => 40, 'company_id' => 2 ],// Create New Client
            ['role_id' => 3 ,'permission_id' => 41, 'company_id' => 2 ],// Edit Clients
            ['role_id' => 3 ,'permission_id' => 42, 'company_id' => 2 ],// Delete Client
            ['role_id' => 3 ,'permission_id' => 43, 'company_id' => 2 ],// Show Supervisor
            ['role_id' => 3 ,'permission_id' => 44, 'company_id' => 2 ],// Create New Supervisor
            ['role_id' => 3 ,'permission_id' => 47, 'company_id' => 2 ],// Show Technicians
            ['role_id' => 3 ,'permission_id' => 48, 'company_id' => 2 ],// Create New Technician
            ['role_id' => 3 ,'permission_id' => 49, 'company_id' => 2 ],// Edit Technicians
            ['role_id' => 3 ,'permission_id' => 50, 'company_id' => 2 ],// Delete Technician
            ['role_id' => 3 ,'permission_id' => 51, 'company_id' => 2 ],// Show Invoices
            ['role_id' => 3 ,'permission_id' => 53, 'company_id' => 2 ],// Create New Payment
            ['role_id' => 3 ,'permission_id' => 54, 'company_id' => 2 ],// Show Payments

            // Technician
            ['role_id' => 4, 'permission_id' => 1, 'company_id' => 2],// Show Reports
            ['role_id' => 4, 'permission_id' => 2, 'company_id' => 2],// Create New Report
            ['role_id' => 4, 'permission_id' => 7, 'company_id' => 2],// Show Work Orders
            ['role_id' => 4, 'permission_id' => 8, 'company_id' => 2],// Create New Work Order
            ['role_id' => 4 ,'permission_id' => 10, 'company_id' => 2 ],// Finish Work Orders
            ['role_id' => 4 ,'permission_id' => 14, 'company_id' => 2 ],// Show Works
            ['role_id' => 4 ,'permission_id' => 15, 'company_id' => 2 ],// Create New Work
            ['role_id' => 4 ,'permission_id' => 17, 'company_id' => 2 ],// Add Before Photos for Work
            ['role_id' => 4 ,'permission_id' => 20, 'company_id' => 2 ],// Show Services
            ['role_id' => 4 ,'permission_id' => 29, 'company_id' => 2 ],// Show Chemicals
            ['role_id' => 4 ,'permission_id' => 30, 'company_id' => 2 ],// Create New Chemical
            ['role_id' => 4 ,'permission_id' => 33, 'company_id' => 2 ],// Show Equipment
            ['role_id' => 4 ,'permission_id' => 34, 'company_id' => 2 ],// Create New Equipment
            ['role_id' => 4 ,'permission_id' => 36, 'company_id' => 2 ],// Add Photos for Equipment
            ['role_id' => 4 ,'permission_id' => 43, 'company_id' => 2 ],// Show Supervisor
        ]);

    }
}
