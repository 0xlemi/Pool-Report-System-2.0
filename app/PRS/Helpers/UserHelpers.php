<?php

namespace App\PRS\Helpers;

use App\User;

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

    /**
     * Get the number of the notification setting if you only change one type
     * @param  User   $user
     * @param  string $name  The notification setting
     * @param  string $type  notification type
     * @param  bool   $value
     * @return int
     */
    public function notificationChanged(User $user, string $name, string $type, bool $value)
    {
        $notificationPermissonsArray  = $this->notificationPermissonToArray($user->$name);
        $positonOfTypeToChange = $this->notificationTypePosition($type);
        $notificationPermissonsArray[$positonOfTypeToChange] = (int) $value;
        return $this->notificationPermissionToNum($notificationPermissonsArray);
    }

    // get the notifacations that are permited in array format from integer
    public function notificationPermissonToArray(int $num)
    {
        // depending on the notifaation types is the ammount of zeros to fill
        $numOfTypes = count(config('constants.notificationTypes'));
        // Transform ints to booleans
        return array_map(function($num){
                    return (int) $num;
                },
                    // reverse the order so it starts at monday
                    array_reverse(
                        // make it an array
                        str_split(
                            // fill missing zeros
                            sprintf( "%0{$numOfTypes}d",
                                // transform num to binary
                                decbin($num)
                            )
                        )
                    )
                );
    }

    /**
     * Get the index possition of the type depending on
     * the config constant notifacation types array
     * @param  string $type
     * @return integer        The index
     * tested
     */
    public function notificationTypePosition(string $type)
    {
        return array_search($type ,array_keys(config('constants.notificationTypes')));
    }

    /**
     * Transform binary array to number
     * @param  array  $array
     * @return int
     * tested
     */
    public function notificationPermissionToNum(array $array)
    {
        $binaryNumber = implode('', array_reverse($array));
        return bindec($binaryNumber);
    }

}
