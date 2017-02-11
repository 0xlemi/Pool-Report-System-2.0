<?php

namespace App\PRS\ValueObjects\User;
use App\User;


class NotificationSettings {


    protected $settings;

    public function __construct(User $user)
    {
        $this->settings = $this->buildSettings($user);
    }

    public function settings()
    {
        return $this->settings;
    }

    // Get buttons settings from integer
    protected function getButtons($num)
    {
        // Transform ints to booleans
        $notify = array_map(function($num){
                    return (boolean) $num;
                },
                    // reverse the order so it starts at monday
                    array_reverse(
                        // make it an array
                        str_split(
                            // fill missing zeros
                            sprintf( "%07d",
                                // transform num to binary
                                decbin($num)
                            )
                        )
                    )
                );
        $result = [];
        foreach (config('constants.notificationTypes') as $type => $icon) {
            $result[] = (object)[
                'type' => $type,
                'icon'  => $icon,
                'value'  => array_shift($notify),
            ];
        }
        return $result;
    }

    private function buildSettings(User $user)
    {
        $notifications = config('constants.notifications');
        $result = [];
        foreach($notifications as $name => $tag) {
            $result[] = (object)[ 'tag' => $tag , 'name' => $name, 'buttons' => $this->getButtons($user->$name)];
        }
        return $result;

    }

}
