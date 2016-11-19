<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Equipment;

class AddedEquipmentNotification extends Notification
{
    use Queueable;

    protected $equipment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Equipment $equipment)
    {
        $this->equipment = $equipment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
        return [
            'title' => "New <strong>Equipment</strong> was added to <strong>Service</strong> \"{$service->seq_id} {$service->name}\"",
            'message' => "New <strong>Equipment</strong> was added to the <strong>Service</strong> (<a href=\"../services/{$service->seq_id}\">{$service->name}</a>).",
        ];
    }
}
