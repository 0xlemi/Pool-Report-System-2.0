<?php

namespace App\PRS\ValueObjects\User;
use App\User;
use App\PRS\Helpers\UserHelpers;


class NotificationSettings {


    protected $user;
    protected $userHelper;

    public function __construct(User $user, UserHelpers $userHelper)
    {
        $this->userHelper = $userHelper;
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->buildSettings();
    }

    public function get($name)
    {
        return $this->getButtons($user->$name, $name);
    }

    /**
     * Check if user has recives notification given the notification and type
     * @param  string  $name
     * @param  string  $type
     * @return boolean
     * don't need test
     */
    public function hasPermission(string $name, string $type)
    {
        // If user is not activated don't send emails to them
        // They dont yet agree to use the system
        if(!$this->user->verified){
            return false;
        }
        $notificationPermissonsArray = $this->userHelper->notificationPermissonToArray($this->user->$name);
        $positonOfType = $this->userHelper->notificationTypePosition($type);
        return (bool) $notificationPermissonsArray[$positonOfType];
    }

    /**
     * Get the number of the notification setting if you only change one type
     * @param  string $name  The notification setting
     * @param  string $type  notification type
     * @param  bool   $value
     * @return int
     * don't need test
     */
    public function notificationChanged(string $name, string $type, bool $value)
    {
        $notificationPermissonsArray  = $this->userHelper->notificationPermissonToArray($this->user->$name);
        $positonOfTypeToChange = $this->userHelper->notificationTypePosition($type);
        $notificationPermissonsArray[$positonOfTypeToChange] = (int) $value;
        return $this->userHelper->notificationPermissionToNum($notificationPermissonsArray);
    }

    public function validNames()
    {
        return config('constants.notifications'.$this->user->type);
    }

    // Get buttons settings from integer
    protected function getButtons(int $num, string $name)
    {
        $notificationInfo = config('constants.notifications')->$name;
        $notificationTypesInfo = config('constants.notificationTypes');
        $notify = $this->userHelper->notificationPermissonToArray($num);
        $result = [];
        foreach ($notificationInfo->types as $type) {
            $result[] = (object)[
                'type' => $type,
                'icon'  => $notificationTypesInfo->$type ,
                'value'  => array_shift($notify),
            ];
        }
        return $result;
    }

    private function buildSettings()
    {
        $notificationsForUser = $this->validNames();
        $notificationsInfo = config('constants.notifications');
        $result = [];
        foreach($notificationsForUser as $name) {
            $result[] = (object)[ 'tag' => $notificationsInfo->$name->tag , 'name' => $name, 'buttons' => $this->getButtons($this->user->$name, $name)];
        }
        return $result;

    }

}
