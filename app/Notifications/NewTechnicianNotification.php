<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Technician;

class NewTechnicianNotification extends Notification
{
    use Queueable;

    protected $technician;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Technician $technician)
    {
        $this->technician = $technician;
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
        $technician = $this->technician;
        return [
            'icon' => url($technician->icon()),
            'link' => "technicians/{$technician->seq_id}",
            'title' => "New <strong>Technician</strong> was created",
            'message' => "New <strong>Technician</strong> (<a href=\"../technicians/{$technician->seq_id}\">{$technician->name} {$technician->last_name}</a>) has been created.",
        ];
    }
}
