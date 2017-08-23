<?php

use Illuminate\Database\Seeder;
use App\UserRoleCompany;
use App\Service;
use App\User;
use App\Image;
use App\PRS\Helpers\SeederHelpers;
use App\Jobs\SendBird\CreateUser;

class UserTableSeeder extends Seeder
{

    private $seederHelper;

    public function __construct(SeederHelpers $seederHelper)
    {
        $this->seederHelper = $seederHelper;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numOfClients = rand(40, 70);
        $numOfSupervisors = rand(9, 10);
        $numOfTechnicians = rand(15, 30);
        $withSendbirdUsers = false;

        UserRoleCompany::flushEventListeners();
        User::flushEventListeners();
        Image::flushEventListeners();

        for ($i=0; $i < $numOfClients; $i++)
        {
            // woman or men
			$gender = (rand(0,1)) ? 'male':'female';

        	// generate and save image and tn_image
			$img = $this->seederHelper->get_random_image('client/'.$gender, 20);

            // get the service id for the pivot table
            $serviceId = $this->seederHelper->getRandomObject('services');

            // find admin_id congruent with the service
            $company = Service::findOrFail($serviceId)->company;

    		$user = factory(User::class)->create();
            $user->verified = true;
            $user->save();

            $userRoleCompany = factory(UserRoleCompany::class)->create([
                'name_extra' => $user->name,
                'last_name_extra' => $user->last_name,
                'email_extra' => $user->email,
                'chat_id' => Uuid::generate()->string,
                'chat_nickname' => $user->fullName.' - '.title_case('client'),
                'user_id' => $user->id,
                'role_id' => 2,
                'company_id' => $company->id,
            ]);
            $userRoleCompany->accepted = true;
            $userRoleCompany->paid = true;
            $userRoleCompany->save();
            if($withSendbirdUsers){
                dispatch(new CreateUser($userRoleCompany));
            }

            DB::table('urc_notify_setting')->insert([
                [ 'notify_setting_id' => 1, 'urc_id' => $userRoleCompany->id ],// Notification when Report is Created
                [ 'notify_setting_id' => 2, 'urc_id' => $userRoleCompany->id ],// Notification when Work Order is Created
                [ 'notify_setting_id' => 3, 'urc_id' => $userRoleCompany->id ],// Notification when Service is Created
                [ 'notify_setting_id' => 7, 'urc_id' => $userRoleCompany->id ],// Notification when Invoice is Created
                [ 'notify_setting_id' => 8, 'urc_id' => $userRoleCompany->id ],// Notification when Payment is Created
                [ 'notify_setting_id' => 9, 'urc_id' => $userRoleCompany->id ],// Notification when Work is added to Work Order
                [ 'notify_setting_id' => 10, 'urc_id' => $userRoleCompany->id ],// Notification when Measurement is added to Service
                [ 'notify_setting_id' => 11, 'urc_id' => $userRoleCompany->id ],// Notification when Equipment is added to Service
                [ 'notify_setting_id' => 12, 'urc_id' => $userRoleCompany->id ],// Notification when Contract is added to Service
                [ 'notify_setting_id' => 13, 'urc_id' => $userRoleCompany->id ],// Email when Report is Created
                [ 'notify_setting_id' => 14, 'urc_id' => $userRoleCompany->id ],// Email when Work Order is Created
                [ 'notify_setting_id' => 15, 'urc_id' => $userRoleCompany->id ],// Email when Service is Created
                [ 'notify_setting_id' => 19, 'urc_id' => $userRoleCompany->id ],// Email when Invoice is Created
                [ 'notify_setting_id' => 20, 'urc_id' => $userRoleCompany->id ],// Email when Payment is Created
            ]);

            // need to attach this user to some services
            $userRoleCompany->services()->attach($serviceId);

            // create images link it to client
            $userRoleCompany->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'processing' => 0,
            ]);
        }

        for ($i=0; $i < $numOfSupervisors; $i++)
        {
            // generate and save image and tn_image
    		$img = $this->seederHelper->get_random_image('supervisor', 5);

            // get a random company_id that exists in database
            $company_id = rand(1,2);

    		$user = factory(User::class)->create();
            $user->verified = true;
            $user->save();

            $userRoleCompany = factory(UserRoleCompany::class)->create([
                'name_extra' => $user->name,
                'last_name_extra' => $user->last_name,
                'email_extra' => $user->email,
                'chat_id' => Uuid::generate()->string,
                'chat_nickname' => $user->fullName.' - '.title_case('sup'),
                'user_id' => $user->id,
                'role_id' => 3,
                'company_id' => $company_id,
            ]);
            if($i == 0){
                $userRoleCompany->device_id = 'iPhone_9D2093A0-5DEA-499A-A1F4-DF3C41C9D777';
                $userRoleCompany->paid = true;
            }
            $userRoleCompany->accepted = true;
            $userRoleCompany->save();
            if($withSendbirdUsers){
                dispatch(new CreateUser($userRoleCompany));
            }

            DB::table('urc_notify_setting')->insert([
                [ 'notify_setting_id' => 1, 'urc_id' => $userRoleCompany->id ],// Notification when Report is Created
                [ 'notify_setting_id' => 2, 'urc_id' => $userRoleCompany->id ],// Notification when Work Order is Created
                [ 'notify_setting_id' => 3, 'urc_id' => $userRoleCompany->id ],// Notification when Service is Created
                [ 'notify_setting_id' => 4, 'urc_id' => $userRoleCompany->id ],// Notification when Client is Created
                [ 'notify_setting_id' => 5, 'urc_id' => $userRoleCompany->id ],// Notification when Supervisor is Created
                [ 'notify_setting_id' => 6, 'urc_id' => $userRoleCompany->id ],// Notification when Technician is Created
                [ 'notify_setting_id' => 7, 'urc_id' => $userRoleCompany->id ],// Notification when Invoice is Created
                [ 'notify_setting_id' => 8, 'urc_id' => $userRoleCompany->id ],// Notification when Payment is Created
                [ 'notify_setting_id' => 9, 'urc_id' => $userRoleCompany->id ],// Notification when Work is added to Work Order
                [ 'notify_setting_id' => 10, 'urc_id' => $userRoleCompany->id ],// Notification when Measurement is added to Service
                [ 'notify_setting_id' => 11, 'urc_id' => $userRoleCompany->id ],// Notification when Equipment is added to Service
                [ 'notify_setting_id' => 12, 'urc_id' => $userRoleCompany->id ],// Notification when Contract is added to Service
                [ 'notify_setting_id' => 13, 'urc_id' => $userRoleCompany->id ],// Email when Report is Created
                [ 'notify_setting_id' => 14, 'urc_id' => $userRoleCompany->id ],// Email when Work Order is Created
                [ 'notify_setting_id' => 15, 'urc_id' => $userRoleCompany->id ],// Email when Service is Created
                [ 'notify_setting_id' => 16, 'urc_id' => $userRoleCompany->id ],// Email when Client is Created
                [ 'notify_setting_id' => 17, 'urc_id' => $userRoleCompany->id ],// Email when Supervisor is Created
                [ 'notify_setting_id' => 18, 'urc_id' => $userRoleCompany->id ],// Email when Technician is Created
                [ 'notify_setting_id' => 19, 'urc_id' => $userRoleCompany->id ],// Email when Invoice is Created
                [ 'notify_setting_id' => 20, 'urc_id' => $userRoleCompany->id ],// Email when Payment is Created
            ]);

            // create images link it to supervisors
            $userRoleCompany->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'processing' => 0,
            ]);

        }

        for ($i=0; $i < $numOfTechnicians; $i++)
        {
            // generate and save image and tn_image
			$img = $this->seederHelper->get_random_image('technician', 20);

            // get a random company_id that exists in database
            $company_id = rand(1,2);

    		$user = factory(User::class)->create();
            $user->verified = true;
            $user->save();

            $userRoleCompany = factory(UserRoleCompany::class)->create([
                'name_extra' => $user->name,
                'last_name_extra' => $user->last_name,
                'email_extra' => $user->email,
                'chat_id' => Uuid::generate()->string,
                'chat_nickname' => $user->fullName.' - '.title_case('tech'),
                'user_id' => $user->id,
                'role_id' => 4,
                'company_id' => $company_id,
            ]);
            $userRoleCompany->accepted = true;
            $userRoleCompany->save();
            if($withSendbirdUsers){
                dispatch(new CreateUser($userRoleCompany));
            }

            DB::table('urc_notify_setting')->insert([
                [ 'notify_setting_id' => 1, 'urc_id' => $userRoleCompany->id ],// Notification when Report is Created
                [ 'notify_setting_id' => 2, 'urc_id' => $userRoleCompany->id ],// Notification when Work Order is Created
                [ 'notify_setting_id' => 3, 'urc_id' => $userRoleCompany->id ],// Notification when Service is Created
                [ 'notify_setting_id' => 9, 'urc_id' => $userRoleCompany->id ],// Notification when Work is added to Work Order
                [ 'notify_setting_id' => 10, 'urc_id' => $userRoleCompany->id ],// Notification when Measurement is added to Service
                [ 'notify_setting_id' => 11, 'urc_id' => $userRoleCompany->id ],// Notification when Equipment is added to Service
                [ 'notify_setting_id' => 12, 'urc_id' => $userRoleCompany->id ],// Notification when Contract is added to Service
                [ 'notify_setting_id' => 13, 'urc_id' => $userRoleCompany->id ],// Email when Report is Created
                [ 'notify_setting_id' => 14, 'urc_id' => $userRoleCompany->id ],// Email when Work Order is Created
                [ 'notify_setting_id' => 15, 'urc_id' => $userRoleCompany->id ],// Email when Service is Created
            ]);

    		// create images link it to technician
            $userRoleCompany->images()->create([
                'big' => $img->big,
    			'medium' => $img->medium,
                'thumbnail' => $img->thumbnail,
                'icon' => $img->icon,
                'processing' => 0,
            ]);
        }
    }
}
