<?php

namespace App\PRS\ValueObjects\User;
use App\User;
use App\PRS\Helpers\UserHelpers;


class NotificationSettings {


    protected $settings;
    protected $userHelper;

    public function __construct(User $user, UserHelpers $userHelper)
    {
        $this->userHelper = $userHelper;
        $this->settings = $this->buildSettings($user);
    }

    public function getAll()
    {
        return $this->settings;
    }

    public function get($name)
    {
        return $this->getButtons($user->$name);
    }

    // Get buttons settings from integer
    protected function getButtons($num)
    {
        $notify = $this->userHelper->notificationPermissonToArray($num);
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
