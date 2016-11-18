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
        return [
            'title' => "New equipment was added",
            'message' => "New equipment was added to {$this->equipment->service->name} service.",
        ];
    }
}
