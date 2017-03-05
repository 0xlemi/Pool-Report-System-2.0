<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Equipment;

class AddedEquipmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $equipment;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Equipment $equipment, User $user)
    {
        $this->equipment = $equipment;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [];
        if($notifiable->notificationSettings->hasPermission('notify_equipment_added', 'database')){
        $channels[] = 'database';
        }
        return $channels;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $service = $this->equipment->service();
        $userable = $this->user->userable();
        $type = $this->user->type;
        $urlName = $type->url();

        $person =  "<strong>System Administrator</strong>";
        if(!$this->user->isAdministrator()){
            $person = "<strong>{$type}</strong> (<a href=\"../{$urlName}/{$userable->seq_id}\">{$this->user->fullName}</a>)";
        }
        return [
            'icon' => url($this->equipment->icon()),
            'title' => "New <strong>Equipment</strong> was added to <strong>Service</strong> \"{$service->seq_id} {$service->name}\"",
            'message' => "New <strong>Equipment</strong> was added to the <strong>Service</strong>
                            (<a href=\"../services/{$service->seq_id}\">{$service->name}</a>) by {$person}.",
        ];
    }
}
