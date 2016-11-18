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
        return [
            'link' => "technicians/{$this->technician->seq_id}",
            'title' => "New technician was created",
            'message' => "New technician has been created.",
        ];
    }
}
