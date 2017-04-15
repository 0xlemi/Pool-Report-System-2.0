<?php

namespace App\Events;

use App\UserRoleCompany;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserRoleCompanyRegistered
{
    use SerializesModels;

    public $userRoleCompany;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserRoleCompany $userRoleCompany)
    {
        $this->userRoleCompany = $userRoleCompany;
    }
}
