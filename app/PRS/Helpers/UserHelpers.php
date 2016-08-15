<?php

namespace App\PRS\Helpers;

/**
 * Helpers for user elements
 */
class UserHelpers
{

    public function styledType($type, $simple = false)
    {
        if($type == 'App\Administrator'){
            if($simple){
                return 'System Administrator';
            }
            return '<i class="font-icon glyphicon glyphicon-cog "></i>
                        <span>System Administrator</span>';
        }elseif($type == 'App\Supervisor'){
            if($simple){
                return 'Supervisor';
            }
            return '<i class="font-icon glyphicon glyphicon-eye-open "></i>
                        <span>Supervisor</span>';
        }elseif($type == 'App\Technician'){
            if($simple){
                return 'Technician';
            }
            return '<i class="font-icon glyphicon glyphicon-wrench "></i>
                        <span>Technician</span>';
        }elseif($type == 'App\Client'){
            if($simple){
                return 'Client';
            }
            return '<i class="font-icon glyphicon glyphicon-user "></i>
                        <span>Client</span>';
        }
    }

}
