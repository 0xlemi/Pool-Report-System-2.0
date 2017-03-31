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

    function styleEmailPermissions($user)
    {
        $result = '';
        $num = 0;
        if($user->notificationSettings->hasPermission('notify_report_created', 'mail')){
            $result .= '<span class="label label-primary">New Report is Created</span><br>';
            $num++;
        }

        if($num == 0){
            return '<span class="label label-default">Never Receives Emails</span>';
        }
        return $result;

    }

}
