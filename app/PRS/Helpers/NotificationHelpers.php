<?php

namespace App\PRS\Helpers;

use App\PRS\Traits\HelperTrait;
use App\UserRoleCompany;

use App\User;

/**
 * Helpers for notification elements
 */
class NotificationHelpers
{

use HelperTrait;

    public function channels(UserRoleCompany $userRoleCompany, $permissionName)
    {
        $channels = [];
        if($userRoleCompany->hasNotificationSetting($permissionName, 'database')){
            $channels[] = 'database';
        }if($userRoleCompany->hasNotificationSetting($permissionName, 'mail')){
            $channels[] = 'mail';
        }
        return $channels;
    }

    public function personStyled(UserRoleCompany $userRoleCompany)
    {
        $role = $userRoleCompany->role;
        $name = $userRoleCompany->user->fullName;
        $seq_id = $userRoleCompany->seq_id;

        if($role->name == 'admin'){
            return "<strong>{$role->text}</strong>";
        }elseif($role->name == 'client'){
            return "<strong>{$role->text}</strong> (<a href=\"../clients/{$seq_id}\">{$name}</a>)";
        }elseif($role->name == 'sup'){
            return "<strong>{$role->text}</strong> (<a href=\"../supervisors/{$seq_id}\">{$name}</a>)";
        }elseif($role->name == 'tech'){
            return "<strong>{$role->text}</strong> (<a href=\"../technicians/{$seq_id}\">{$name}</a>)";
        }
    }

}
