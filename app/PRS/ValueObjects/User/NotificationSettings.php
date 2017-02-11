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
        return [
            (object)[
                'type' => 'database',
                'icon'  => 'font-icon font-icon-alarm',
                'value'  => $notify[0],
            ],
            (object)[
                'type' => 'mail',
                'icon'  => 'font-icon font-icon-mail',
                'value'  => $notify[1],
            ],
        ];
    }

    private function buildSettings(User $user)
    {
        return [
            (object)[ 'label' => "Report Created" , 'name' => 'notify_report_created', 'buttons' => $this->getButtons($user->notify_report_created) ],
        ];

    }

}
