<?php

namespace App\PRS\Traits;

trait HelperTrait{

    function styleEmailPermissions($person)
    {
        $result = '';
        $num = 0;
        if($person->get_reports_emails){
            $result .= '<span class="label label-primary">New Report is Created</span><br>';
            $num++;
        }

        if($num == 0){
            return '<span class="label label-default">Never Receives Emails</span>';
        }
        return $result;

    }

}
