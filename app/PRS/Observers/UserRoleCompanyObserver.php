<?php

namespace App\PRS\Observers;

use DB;
use Uuid;
use App\User;
use App\Notifications\NewUserRoleCompanyNotification;
use App\UserRoleCompany;
use App\Jobs\UpdateSubscriptionQuantity;
use App\Jobs\CreateAndSendVerificationToken;


class UserRoleCompanyObserver
{

    /**
     * Listen to the User created event.
     *
     * @param  User  $userRoleCompany
     * @return void
     */
    public function created(UserRoleCompany $userRoleCompany)
    {
        $this->setNotificationsSettings($userRoleCompany);

        // Update billing variables
        if($userRoleCompany->isRole('sup', 'tech')){
            dispatch(new UpdateSubscriptionQuantity($userRoleCompany->company));
        }

        // Means the User was just created and needs verification
        if($userRoleCompany->user->userRoleCompanies()->count() == 1){
            dispatch(new CreateAndSendVerificationToken($userRoleCompany));
        }

        // Generate Chat Id and Token
        // $userRoleCompany->chat_id  = Uuid::generate();
        // $userRoleCompany->chat_token  = );
        // $userRoleCompany->save();

        // Send Notifications
        $urc = auth()->user()->selectedUser;
        $people = $userRoleCompany->company->userRoleCompanies()->ofRole('admin', 'sup')->get();
        foreach ($people as $person) {
            // the supervisor creted should not be notified of his own creation
            if(!($person->id == $userRoleCompany->id)){
                $person->notify(new NewUserRoleCompanyNotification($userRoleCompany, $urc));
            }
        }
    }

    /**
     * Listen to the userRoleCompany saved event.
     *
     * @param  Technician  $userRoleCompany
     * @return void
     */
    public function saved(UserRoleCompany $userRoleCompany)
    {
        // Update billing variables
        if($userRoleCompany->isRole('sup', 'tech')){
            dispatch(new UpdateSubscriptionQuantity($userRoleCompany->company));
        }
    }

    /**
     * Listen to the App\UserRoleCompany deleting event.
     *
     * @param  App\UserRoleCompany  $userRoleCompany
     * @return void
     */
    public function deleted(UserRoleCompany $userRoleCompany)
    {
        dispatch(new DeleteImagesFromS3($userRoleCompany->images));
    }


    protected function setNotificationsSettings(UserRoleCompany $userRoleCompany)
    {
        if($userRoleCompany->isRole('admin')){
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
                [ 'notify_setting_id' => 10, 'urc_id' => $userRoleCompany->id ],// Notification when Chemical is added to Service
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
        }elseif($userRoleCompany->isRole('client')){
            DB::table('urc_notify_setting')->insert([
                [ 'notify_setting_id' => 1, 'urc_id' => $userRoleCompany->id ],// Notification when Report is Created
                [ 'notify_setting_id' => 2, 'urc_id' => $userRoleCompany->id ],// Notification when Work Order is Created
                [ 'notify_setting_id' => 3, 'urc_id' => $userRoleCompany->id ],// Notification when Service is Created
                [ 'notify_setting_id' => 7, 'urc_id' => $userRoleCompany->id ],// Notification when Invoice is Created
                [ 'notify_setting_id' => 8, 'urc_id' => $userRoleCompany->id ],// Notification when Payment is Created
                [ 'notify_setting_id' => 9, 'urc_id' => $userRoleCompany->id ],// Notification when Work is added to Work Order
                [ 'notify_setting_id' => 10, 'urc_id' => $userRoleCompany->id ],// Notification when Chemical is added to Service
                [ 'notify_setting_id' => 11, 'urc_id' => $userRoleCompany->id ],// Notification when Equipment is added to Service
                [ 'notify_setting_id' => 12, 'urc_id' => $userRoleCompany->id ],// Notification when Contract is added to Service
                [ 'notify_setting_id' => 13, 'urc_id' => $userRoleCompany->id ],// Email when Report is Created
                [ 'notify_setting_id' => 14, 'urc_id' => $userRoleCompany->id ],// Email when Work Order is Created
                [ 'notify_setting_id' => 15, 'urc_id' => $userRoleCompany->id ],// Email when Service is Created
                [ 'notify_setting_id' => 19, 'urc_id' => $userRoleCompany->id ],// Email when Invoice is Created
                [ 'notify_setting_id' => 20, 'urc_id' => $userRoleCompany->id ],// Email when Payment is Created
            ]);
        }elseif($userRoleCompany->isRole('sup')){
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
                [ 'notify_setting_id' => 10, 'urc_id' => $userRoleCompany->id ],// Notification when Chemical is added to Service
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
        }elseif($userRoleCompany->isRole('tech')){
            DB::table('urc_notify_setting')->insert([
                [ 'notify_setting_id' => 1, 'urc_id' => $userRoleCompany->id ],// Notification when Report is Created
                [ 'notify_setting_id' => 2, 'urc_id' => $userRoleCompany->id ],// Notification when Work Order is Created
                [ 'notify_setting_id' => 3, 'urc_id' => $userRoleCompany->id ],// Notification when Service is Created
                [ 'notify_setting_id' => 9, 'urc_id' => $userRoleCompany->id ],// Notification when Work is added to Work Order
                [ 'notify_setting_id' => 10, 'urc_id' => $userRoleCompany->id ],// Notification when Chemical is added to Service
                [ 'notify_setting_id' => 11, 'urc_id' => $userRoleCompany->id ],// Notification when Equipment is added to Service
                [ 'notify_setting_id' => 12, 'urc_id' => $userRoleCompany->id ],// Notification when Contract is added to Service
                [ 'notify_setting_id' => 13, 'urc_id' => $userRoleCompany->id ],// Email when Report is Created
                [ 'notify_setting_id' => 14, 'urc_id' => $userRoleCompany->id ],// Email when Work Order is Created
                [ 'notify_setting_id' => 15, 'urc_id' => $userRoleCompany->id ],// Email when Service is Created
            ]);
        }
    }
}
