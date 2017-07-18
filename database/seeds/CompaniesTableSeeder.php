<?php

use Illuminate\Database\Seeder;
use App\Company;
use App\Measurement;
use App\GlobalMeasurement;
use App\UserRoleCompany;
use App\User;
use App\Image;
use App\Label;
use App\Jobs\SendBird\CreateUser;

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
        Measurement::flushEventListeners();
        GlobalMeasurement::flushEventListeners();
        Label::flushEventListeners();
        Image::flushEventListeners();

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
        ]);

        $userRoleCompany1 = factory(UserRoleCompany::class)->create([
            'chat_id' => Uuid::generate()->string,
            'chat_nickname' => $user1->fullName.' - '.title_case('admin'),
            'user_id' => $user1->id,
    		'role_id' => 1,
    		'company_id' => $company1->id,
    		'selected' => true,
            'paid' => true,
        ]);
        dispatch(new CreateUser($userRoleCompany1));

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
            'chat_id' => Uuid::generate()->string,
            'chat_nickname' => $user2->fullName.' - '.title_case('admin'),
            'user_id' => $user2->id,
    		'role_id' => 1,
    		'company_id' => $company2->id,
    		'selected' => true,
            'paid' => true,
        ]);
        dispatch(new CreateUser($userRoleCompany2));


        // Make Other UserRoleCompany on the same user to test changeURC Functionality
        $urcOwnCompanyClient1 = factory(UserRoleCompany::class)->create([
            'chat_id' => Uuid::generate()->string,
            'chat_nickname' => $user1->fullName.' - '.title_case('client'),
            'user_id' => $user1->id,
    		'role_id' => 2,
    		'company_id' => $company1->id,
    		'selected' => false,
        ]);
        dispatch(new CreateUser($urcOwnCompanyClient1));

        $urcOtherCompanySupervisor1 = factory(UserRoleCompany::class)->create([
            'chat_id' => Uuid::generate()->string,
            'chat_nickname' => $user1->fullName.' - '.title_case('sup'),
            'user_id' => $user1->id,
    		'role_id' => 3,
    		'company_id' => $company2->id,
    		'selected' => false,
        ]);
        dispatch(new CreateUser($urcOtherCompanySupervisor1));

        $urcOwnCompanyClient2 = factory(UserRoleCompany::class)->create([
            'chat_id' => Uuid::generate()->string,
            'chat_nickname' => $user2->fullName.' - '.title_case('client'),
            'user_id' => $user2->id,
    		'role_id' => 2,
    		'company_id' => $company2->id,
    		'selected' => false,
        ]);
        dispatch(new CreateUser($urcOwnCompanyClient2));

        $urcOtherCompanyTechnician2 = factory(UserRoleCompany::class)->create([
            'chat_id' => Uuid::generate()->string,
            'chat_nickname' => $user2->fullName.' - '.title_case('tech'),
            'user_id' => $user2->id,
    		'role_id' => 4,
    		'company_id' => $company1->id,
    		'selected' => false,
        ]);
        dispatch(new CreateUser($urcOtherCompanyTechnician2));

        // ***************************
        //   Create Global Products
        // ***************************

        $choline1 = $company1->globalProducts()->create([
            'name' => 'Chlorine',
            'brand' => 'Generic Brand',
            'type' => 'Compact Tablets',
            'units' => 'tablets',
            'unit_price' => 0.55,
            'unit_currency' => 'USD',
        ]);
        $sodaAsh1 = $company1->globalProducts()->create([
            'name' => 'Soda Ash',
            'brand' => 'Generic Brand',
            'type' => 'Pouder',
            'units' => 'pounds',
            'unit_price' => 1.3,
            'unit_currency' => 'USD',
        ]);
        $dryAcid1 = $company1->globalProducts()->create([
            'name' => 'Dry Acid',
            'brand' => 'Generic Brand',
            'type' => 'Pouder',
            'units' => 'pounds',
            'unit_price' => 1.9,
            'unit_currency' => 'USD',
        ]);
        $salt1 = $company1->globalProducts()->create([
            'name' => 'Salt',
            'brand' => 'Generic Brand',
            'type' => 'Regular',
            'units' => 'pounds',
            'unit_price' => 0.08,
            'unit_currency' => 'USD',
        ]);

        $choline2 = $company2->globalProducts()->create([
            'name' => 'Chlorine',
            'brand' => 'Generic Brand',
            'type' => 'Compact Tablets',
            'units' => 'tablets',
            'unit_price' => 0.55,
            'unit_currency' => 'USD',
        ]);
        $sodaAsh2 = $company2->globalProducts()->create([
            'name' => 'Soda Ash',
            'brand' => 'Generic Brand',
            'type' => 'Pouder',
            'units' => 'pounds',
            'unit_price' => 1.3,
            'unit_currency' => 'USD',
        ]);
        $dryAcid2 = $company2->globalProducts()->create([
            'name' => 'Dry Acid',
            'brand' => 'Generic Brand',
            'type' => 'Pouder',
            'units' => 'pounds',
            'unit_price' => 1.9,
            'unit_currency' => 'USD',
        ]);
        $salt2 = $company2->globalProducts()->create([
            'name' => 'Salt',
            'brand' => 'Generic Brand',
            'type' => 'Regular',
            'units' => 'pounds',
            'unit_price' => 0.08,
            'unit_currency' => 'USD',
        ]);

        // ***************************
        //   Create Global Measurements
        // ***************************

        $chlorine1 = $company1->globalMeasurements()->create([
            'name' =>  'Chlorine',
        ]);
            $chlorine1->labels()->create([
                'name' => '0.5 PPM - Low',
                'color' => 'FDFFCD',
                'value' => 1
            ]);
            $chlorine1->labels()->create([
                'name' => '1.0 PPM - Pool OK',
                'color' => 'E6DFD5',
                'value' => 2
            ]);
            $chlorine1->labels()->create([
                'name' => '2.0 PPM - Pool OK',
                'color' => 'AD8CD3',
                'value' => 3
            ]);
            $chlorine1->labels()->create([
                'name' => '3.0 PPM - Spa OK',
                'color' => 'A069BD',
                'value' => 4
            ]);
            $chlorine1->labels()->create([
                'name' => '5.0 PPM - High',
                'color' => '7D1A98',
                'value' => 5
            ]);
        $ph1 = $company1->globalMeasurements()->create([
            'name' =>  'PH Adjuster',
        ]);
            $ph1->labels()->create([
                'name' => '6.8 pH - Low',
                'color' => 'FFB204',
                'value' => 1
            ]);
            $ph1->labels()->create([
                'name' => '7.2 pH - Low',
                'color' => 'EB6C05',
                'value' => 2
            ]);
            $ph1->labels()->create([
                'name' => '7.5 pH - OK',
                'color' => 'DF3A04',
                'value' => 3
            ]);
            $ph1->labels()->create([
                'name' => '7.8 pH - OK',
                'color' => 'DF1803',
                'value' => 4
            ]);
            $ph1->labels()->create([
                'name' => '8.2 pH - High',
                'color' => 'D80317',
                'value' => 5
            ]);
        $salt1 = $company1->globalMeasurements()->create([
            'name' =>  'Salt',
        ]);
            $salt1->labels()->create([
                'name' => 'Very Low',
                'color' => 'DFE0E1',
                'value' => 1
            ]);
            $salt1->labels()->create([
                'name' => 'Low',
                'color' => 'C0C1C4',
                'value' => 2
            ]);
            $salt1->labels()->create([
                'name' => 'Perfect',
                'color' => '8B8C8F',
                'value' => 3
            ]);
            $salt1->labels()->create([
                'name' => 'High',
                'color' => '4C4D4F',
                'value' => 4
            ]);
            $salt1->labels()->create([
                'name' => 'Very High',
                'color' => '131313',
                'value' => 5
            ]);
        $hardness1 = $company1->globalMeasurements()->create([
            'name' =>  'Hardness',
        ]);
            $hardness1->labels()->create([
                'name' => '0 PPM - Low',
                'color' => '00179B',
                'value' => 1
            ]);
            $hardness1->labels()->create([
                'name' => '100 PPM - Low',
                'color' => '2738AE',
                'value' => 2
            ]);
            $hardness1->labels()->create([
                'name' => '250 PPM - OK',
                'color' => '3F2296',
                'value' => 3
            ]);
            $hardness1->labels()->create([
                'name' => '500 PPM - OK',
                'color' => '792D8F',
                'value' => 4
            ]);
            $hardness1->labels()->create([
                'name' => '1000 PPM - High',
                'color' => '861888',
                'value' => 5
            ]);
        $bromine1 = $company1->globalMeasurements()->create([
            'name' =>  'Bromine',
        ]);
            $bromine1->labels()->create([
                'name' => '1 PPM - OK',
                'color' => 'FEFEB6',
                'value' => 1
            ]);
            $bromine1->labels()->create([
                'name' => '2 PPM - OK',
                'color' => 'E7F9A5',
                'value' => 2
            ]);
            $bromine1->labels()->create([
                'name' => '5 PPM - Perfect',
                'color' => 'BCDD8C',
                'value' => 3
            ]);
            $bromine1->labels()->create([
                'name' => '10 PPM - OK',
                'color' => '90C479',
                'value' => 4
            ]);
            $bromine1->labels()->create([
                'name' => '20 PPM - OK',
                'color' => '37A75B',
                'value' => 5
            ]);
        $alkalinity1 = $company1->globalMeasurements()->create([
            'name' =>  'Alkalinity',
        ]);
            $alkalinity1->labels()->create([
                'name' => '20 PPM - Low',
                'color' => 'E4C512',
                'value' => 1
            ]);
            $alkalinity1->labels()->create([
                'name' => '60 PPM - OK',
                'color' => 'A3A42C',
                'value' => 2
            ]);
            $alkalinity1->labels()->create([
                'name' => '120 PPM - OK',
                'color' => '456D31',
                'value' => 3
            ]);
            $alkalinity1->labels()->create([
                'name' => '180 PPM - High',
                'color' => '1F5732',
                'value' => 4
            ]);
            $alkalinity1->labels()->create([
                'name' => '240 PPM - High',
                'color' => '1E4652',
                'value' => 5
            ]);
        $cyanuricAcid1 = $company1->globalMeasurements()->create([
            'name' =>  'Cyanuric Acid',
        ]);
            $cyanuricAcid1->labels()->create([
                'name' => '0 PPM - Low',
                'color' => 'E88101',
                'value' => 1
            ]);
            $cyanuricAcid1->labels()->create([
                'name' => '30-50 PPM - Perfect',
                'color' => 'CD6106',
                'value' => 2
            ]);
            $cyanuricAcid1->labels()->create([
                'name' => '100 PPM - OK',
                'color' => 'B72228',
                'value' => 3
            ]);
            $cyanuricAcid1->labels()->create([
                'name' => '150 PPM - High',
                'color' => 'B3047B',
                'value' => 4
            ]);
            $cyanuricAcid1->labels()->create([
                'name' => '300 PPM - High',
                'color' => '6C057A',
                'value' => 5
            ]);

        // For Company 2
        $chlorine2 = $company2->globalMeasurements()->create([
            'name' =>  'Chlorine',
        ]);
            $chlorine2->labels()->create([
                'name' => '0.5 PPM - Low',
                'color' => 'FDFFCD',
                'value' => 1
            ]);
            $chlorine2->labels()->create([
                'name' => '1.0 PPM - Pool OK',
                'color' => 'E6DFD5',
                'value' => 2
            ]);
            $chlorine2->labels()->create([
                'name' => '2.0 PPM - Pool OK',
                'color' => 'AD8CD3',
                'value' => 3
            ]);
            $chlorine2->labels()->create([
                'name' => '3.0 PPM - Spa OK',
                'color' => 'A069BD',
                'value' => 4
            ]);
            $chlorine2->labels()->create([
                'name' => '5.0 PPM - High',
                'color' => '7D1A98',
                'value' => 5
            ]);
        $ph2 = $company2->globalMeasurements()->create([
            'name' =>  'PH Adjuster',
        ]);
            $ph2->labels()->create([
                'name' => '6.8 pH - Low',
                'color' => 'FFB204',
                'value' => 1
            ]);
            $ph2->labels()->create([
                'name' => '7.2 pH - Low',
                'color' => 'EB6C05',
                'value' => 2
            ]);
            $ph2->labels()->create([
                'name' => '7.5 pH - OK',
                'color' => 'DF3A04',
                'value' => 3
            ]);
            $ph2->labels()->create([
                'name' => '7.8 pH - OK',
                'color' => 'DF1803',
                'value' => 4
            ]);
            $ph2->labels()->create([
                'name' => '8.2 pH - High',
                'color' => 'D80317',
                'value' => 5
            ]);
        $salt2 = $company2->globalMeasurements()->create([
            'name' =>  'Salt',
        ]);
            $salt2->labels()->create([
                'name' => 'Very Low',
                'color' => 'DFE0E1',
                'value' => 1
            ]);
            $salt2->labels()->create([
                'name' => 'Low',
                'color' => 'C0C1C4',
                'value' => 2
            ]);
            $salt2->labels()->create([
                'name' => 'Perfect',
                'color' => '8B8C8F',
                'value' => 3
            ]);
            $salt2->labels()->create([
                'name' => 'High',
                'color' => '4C4D4F',
                'value' => 4
            ]);
            $salt2->labels()->create([
                'name' => 'Very High',
                'color' => '131313',
                'value' => 5
            ]);
        $hardness2 = $company2->globalMeasurements()->create([
            'name' =>  'Hardness',
        ]);
            $hardness2->labels()->create([
                'name' => '0 PPM - Low',
                'color' => '00179B',
                'value' => 1
            ]);
            $hardness2->labels()->create([
                'name' => '100 PPM - Low',
                'color' => '2738AE',
                'value' => 2
            ]);
            $hardness2->labels()->create([
                'name' => '250 PPM - OK',
                'color' => '3F2296',
                'value' => 3
            ]);
            $hardness2->labels()->create([
                'name' => '500 PPM - OK',
                'color' => '792D8F',
                'value' => 4
            ]);
            $hardness2->labels()->create([
                'name' => '1000 PPM - High',
                'color' => '861888',
                'value' => 5
            ]);
        $bromine2 = $company2->globalMeasurements()->create([
            'name' =>  'Bromine',
        ]);
            $bromine2->labels()->create([
                'name' => '1 PPM - OK',
                'color' => 'FEFEB6',
                'value' => 1
            ]);
            $bromine2->labels()->create([
                'name' => '2 PPM - OK',
                'color' => 'E7F9A5',
                'value' => 2
            ]);
            $bromine2->labels()->create([
                'name' => '5 PPM - Perfect',
                'color' => 'BCDD8C',
                'value' => 3
            ]);
            $bromine2->labels()->create([
                'name' => '10 PPM - OK',
                'color' => '90C479',
                'value' => 4
            ]);
            $bromine2->labels()->create([
                'name' => '20 PPM - OK',
                'color' => '37A75B',
                'value' => 5
            ]);
        $alkalinity2 = $company2->globalMeasurements()->create([
            'name' =>  'Alkalinity',
        ]);
            $alkalinity2->labels()->create([
                'name' => '20 PPM - Low',
                'color' => 'E4C512',
                'value' => 1
            ]);
            $alkalinity2->labels()->create([
                'name' => '60 PPM - OK',
                'color' => 'A3A42C',
                'value' => 2
            ]);
            $alkalinity2->labels()->create([
                'name' => '120 PPM - OK',
                'color' => '456D31',
                'value' => 3
            ]);
            $alkalinity2->labels()->create([
                'name' => '180 PPM - High',
                'color' => '1F5732',
                'value' => 4
            ]);
            $alkalinity2->labels()->create([
                'name' => '240 PPM - High',
                'color' => '1E4652',
                'value' => 5
            ]);
        $cyanuricAcid2 = $company2->globalMeasurements()->create([
            'name' =>  'Cyanuric Acid',
        ]);
            $cyanuricAcid2->labels()->create([
                'name' => '0 PPM - Low',
                'color' => 'E88101',
                'value' => 1
            ]);
            $cyanuricAcid2->labels()->create([
                'name' => '30-50 PPM - Perfect',
                'color' => 'CD6106',
                'value' => 2
            ]);
            $cyanuricAcid2->labels()->create([
                'name' => '100 PPM - OK',
                'color' => 'B72228',
                'value' => 3
            ]);
            $cyanuricAcid2->labels()->create([
                'name' => '150 PPM - High',
                'color' => 'B3047B',
                'value' => 4
            ]);
            $cyanuricAcid2->labels()->create([
                'name' => '300 PPM - High',
                'color' => '6C057A',
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
            [ 'notify_setting_id' => 10, 'urc_id' => $userRoleCompany1->id ],// Notification when Measurement is added to Service
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
            [ 'notify_setting_id' => 10, 'urc_id' => $userRoleCompany2->id ],// Notification when Measurement is added to Service
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
            ['role_id' => 3 ,'permission_id' => 29, 'company_id' => 1 ],// Show Measurements
            ['role_id' => 3 ,'permission_id' => 30, 'company_id' => 1 ],// Create New Measurement
            ['role_id' => 3 ,'permission_id' => 31, 'company_id' => 1 ],// Edit Measurements
            ['role_id' => 3 ,'permission_id' => 32, 'company_id' => 1 ],// Delete Measurement
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
            ['role_id' => 4 ,'permission_id' => 29, 'company_id' => 1 ],// Show Measurements
            ['role_id' => 4 ,'permission_id' => 30, 'company_id' => 1 ],// Create New Measurement
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
            ['role_id' => 3 ,'permission_id' => 29, 'company_id' => 2 ],// Show Measurements
            ['role_id' => 3 ,'permission_id' => 30, 'company_id' => 2 ],// Create New Measurement
            ['role_id' => 3 ,'permission_id' => 31, 'company_id' => 2 ],// Edit Measurements
            ['role_id' => 3 ,'permission_id' => 32, 'company_id' => 2 ],// Delete Measurement
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
            ['role_id' => 4 ,'permission_id' => 29, 'company_id' => 2 ],// Show Measurements
            ['role_id' => 4 ,'permission_id' => 30, 'company_id' => 2 ],// Create New Measurement
            ['role_id' => 4 ,'permission_id' => 33, 'company_id' => 2 ],// Show Equipment
            ['role_id' => 4 ,'permission_id' => 34, 'company_id' => 2 ],// Create New Equipment
            ['role_id' => 4 ,'permission_id' => 36, 'company_id' => 2 ],// Add Photos for Equipment
            ['role_id' => 4 ,'permission_id' => 43, 'company_id' => 2 ],// Show Supervisor
        ]);

    }
}
