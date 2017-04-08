<?php

namespace App\PRS\Observers;

use App\User;
use App\Events\UserRegistered;
use App\UserRoleCompany;

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
                [ 'notify_setting_id' => 1, 'urc' => $userRoleCompany ],// Notification when Report is Created
                [ 'notify_setting_id' => 2, 'urc' => $userRoleCompany ],// Notification when Work Order is Created
                [ 'notify_setting_id' => 3, 'urc' => $userRoleCompany ],// Notification when Service is Created
                [ 'notify_setting_id' => 4, 'urc' => $userRoleCompany ],// Notification when Client is Created
                [ 'notify_setting_id' => 5, 'urc' => $userRoleCompany ],// Notification when Supervisor is Created
                [ 'notify_setting_id' => 6, 'urc' => $userRoleCompany ],// Notification when Technician is Created
                [ 'notify_setting_id' => 7, 'urc' => $userRoleCompany ],// Notification when Invoice is Created
                [ 'notify_setting_id' => 8, 'urc' => $userRoleCompany ],// Notification when Payment is Created
                [ 'notify_setting_id' => 9, 'urc' => $userRoleCompany ],// Notification when Work is added to Work Order
                [ 'notify_setting_id' => 10, 'urc' => $userRoleCompany ],// Notification when Chemical is added to Service
                [ 'notify_setting_id' => 11, 'urc' => $userRoleCompany ],// Notification when Equipment is added to Service
                [ 'notify_setting_id' => 12, 'urc' => $userRoleCompany ],// Notification when Contract is added to Service
                [ 'notify_setting_id' => 13, 'urc' => $userRoleCompany ],// Email when Report is Created
                [ 'notify_setting_id' => 14, 'urc' => $userRoleCompany ],// Email when Work Order is Created
                [ 'notify_setting_id' => 15, 'urc' => $userRoleCompany ],// Email when Service is Created
                [ 'notify_setting_id' => 16, 'urc' => $userRoleCompany ],// Email when Client is Created
                [ 'notify_setting_id' => 17, 'urc' => $userRoleCompany ],// Email when Supervisor is Created
                [ 'notify_setting_id' => 18, 'urc' => $userRoleCompany ],// Email when Technician is Created
                [ 'notify_setting_id' => 19, 'urc' => $userRoleCompany ],// Email when Invoice is Created
                [ 'notify_setting_id' => 20, 'urc' => $userRoleCompany ],// Email when Payment is Created
            ]);
        }elseif($userRoleCompany->isRole('client')){
            DB::table('urc_notify_setting')->insert([
                [ 'notify_setting_id' => 1, 'urc' => $userRoleCompany ],// Notification when Report is Created
                [ 'notify_setting_id' => 2, 'urc' => $userRoleCompany ],// Notification when Work Order is Created
                [ 'notify_setting_id' => 3, 'urc' => $userRoleCompany ],// Notification when Service is Created
                [ 'notify_setting_id' => 7, 'urc' => $userRoleCompany ],// Notification when Invoice is Created
                [ 'notify_setting_id' => 8, 'urc' => $userRoleCompany ],// Notification when Payment is Created
                [ 'notify_setting_id' => 9, 'urc' => $userRoleCompany ],// Notification when Work is added to Work Order
                [ 'notify_setting_id' => 10, 'urc' => $userRoleCompany ],// Notification when Chemical is added to Service
                [ 'notify_setting_id' => 11, 'urc' => $userRoleCompany ],// Notification when Equipment is added to Service
                [ 'notify_setting_id' => 12, 'urc' => $userRoleCompany ],// Notification when Contract is added to Service
                [ 'notify_setting_id' => 13, 'urc' => $userRoleCompany ],// Email when Report is Created
                [ 'notify_setting_id' => 14, 'urc' => $userRoleCompany ],// Email when Work Order is Created
                [ 'notify_setting_id' => 15, 'urc' => $userRoleCompany ],// Email when Service is Created
                [ 'notify_setting_id' => 19, 'urc' => $userRoleCompany ],// Email when Invoice is Created
                [ 'notify_setting_id' => 20, 'urc' => $userRoleCompany ],// Email when Payment is Created
            ]);
        }elseif($userRoleCompany->isRole('sup')){
            DB::table('urc_notify_setting')->insert([
                [ 'notify_setting_id' => 1, 'urc' => $userRoleCompany ],// Notification when Report is Created
                [ 'notify_setting_id' => 2, 'urc' => $userRoleCompany ],// Notification when Work Order is Created
                [ 'notify_setting_id' => 3, 'urc' => $userRoleCompany ],// Notification when Service is Created
                [ 'notify_setting_id' => 4, 'urc' => $userRoleCompany ],// Notification when Client is Created
                [ 'notify_setting_id' => 5, 'urc' => $userRoleCompany ],// Notification when Supervisor is Created
                [ 'notify_setting_id' => 6, 'urc' => $userRoleCompany ],// Notification when Technician is Created
                [ 'notify_setting_id' => 7, 'urc' => $userRoleCompany ],// Notification when Invoice is Created
                [ 'notify_setting_id' => 8, 'urc' => $userRoleCompany ],// Notification when Payment is Created
                [ 'notify_setting_id' => 9, 'urc' => $userRoleCompany ],// Notification when Work is added to Work Order
                [ 'notify_setting_id' => 10, 'urc' => $userRoleCompany ],// Notification when Chemical is added to Service
                [ 'notify_setting_id' => 11, 'urc' => $userRoleCompany ],// Notification when Equipment is added to Service
                [ 'notify_setting_id' => 12, 'urc' => $userRoleCompany ],// Notification when Contract is added to Service
                [ 'notify_setting_id' => 13, 'urc' => $userRoleCompany ],// Email when Report is Created
                [ 'notify_setting_id' => 14, 'urc' => $userRoleCompany ],// Email when Work Order is Created
                [ 'notify_setting_id' => 15, 'urc' => $userRoleCompany ],// Email when Service is Created
                [ 'notify_setting_id' => 16, 'urc' => $userRoleCompany ],// Email when Client is Created
                [ 'notify_setting_id' => 17, 'urc' => $userRoleCompany ],// Email when Supervisor is Created
                [ 'notify_setting_id' => 18, 'urc' => $userRoleCompany ],// Email when Technician is Created
                [ 'notify_setting_id' => 19, 'urc' => $userRoleCompany ],// Email when Invoice is Created
                [ 'notify_setting_id' => 20, 'urc' => $userRoleCompany ],// Email when Payment is Created
            ]);
        }elseif($userRoleCompany->isRole('tech')){
            DB::table('urc_notify_setting')->insert([
                [ 'notify_setting_id' => 1, 'urc' => $userRoleCompany ],// Notification when Report is Created
                [ 'notify_setting_id' => 2, 'urc' => $userRoleCompany ],// Notification when Work Order is Created
                [ 'notify_setting_id' => 3, 'urc' => $userRoleCompany ],// Notification when Service is Created
                [ 'notify_setting_id' => 9, 'urc' => $userRoleCompany ],// Notification when Work is added to Work Order
                [ 'notify_setting_id' => 10, 'urc' => $userRoleCompany ],// Notification when Chemical is added to Service
                [ 'notify_setting_id' => 11, 'urc' => $userRoleCompany ],// Notification when Equipment is added to Service
                [ 'notify_setting_id' => 12, 'urc' => $userRoleCompany ],// Notification when Contract is added to Service
                [ 'notify_setting_id' => 13, 'urc' => $userRoleCompany ],// Email when Report is Created
                [ 'notify_setting_id' => 14, 'urc' => $userRoleCompany ],// Email when Work Order is Created
                [ 'notify_setting_id' => 15, 'urc' => $userRoleCompany ],// Email when Service is Created
            ]);
        }
    }
}
