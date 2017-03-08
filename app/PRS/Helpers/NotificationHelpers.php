<?php

namespace App\PRS\Helpers;

use App\PRS\Traits\HelperTrait;

/**
 * Helpers for notification elements
 */
class NotificationHelpers
{

use HelperTrait;

    public function userStyled($user)
    {
        $person =  "<strong>System Administrator</strong>";
        if($user == null){
            // there is no authenticated user (we are running a migration)
            $person =  "<strong>Unknown</strong>";
        }elseif(!$user->isAdministrator()){
            $userable = $user->userable();
            $type = $user->type;
            $urlName = $type->url();
            $person = "<strong>{$type}</strong> (<a href=\"../{$urlName}/{$userable->seq_id}\">{$user->fullName}</a>)";
        }
        return $person;
    }

}
