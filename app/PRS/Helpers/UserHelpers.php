<?php

namespace App\PRS\Helpers;

/**
 * Helpers for user elements
 */
class UserHelpers
{

    public function styledType($type)
    {
        if($type == 'App\Administrator'){
            return '<i class="font-icon glyphicon glyphicon-cog "></i>
                        <span>System Administrator</span>';
        }elseif($type == 'App\Supervisor'){
            return '<i class="font-icon glyphicon glyphicon-eye-open "></i>
                        <span>Supervisor</span>';
        }elseif($type == 'App\Technician'){
            return '<i class="font-icon glyphicon glyphicon-wrench "></i>
                        <span>Technician</span>';
        }elseif($type == 'App\Client'){
            return '<i class="font-icon glyphicon glyphicon-user "></i>
                        <span>Client</span>';
        }
    }

}
