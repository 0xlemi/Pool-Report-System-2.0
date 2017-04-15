<?php

namespace App\PRS\Traits;

use Carbon\Carbon;

trait HelperTrait{

    // dates are NOT sent in UTC
    function format_date(string $date){
    	return (new Carbon($date, 'UTC'))
                ->setTimezone($this->loggedCompany()->timezone)
                ->format('l jS \\of F Y h:i:s A');
    }

    function styleEmailPermissions($userRoleCompany)
    {
        $result = '<span class="label label-default">Never Receives Emails</span>';

        if($userRoleCompany->hasNotificationSetting('notify_report_created', 'mail')){
            $result = '<span class="label label-primary">New Report is Created</span><br>';
        }
        return $result;
    }

}
