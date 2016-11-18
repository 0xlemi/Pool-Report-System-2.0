<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Supervisor;

class NewSupervisorNotification extends Notification
{
    use Queueable;

    protected $supervisor;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Supervisor $supervisor)
    {
        $this->supervisor = $supervisor;
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
            'link' => "supervisors/{$this->supervisor->seq_id}",
            'title' => "New Supervisor was created",
            'message' => "New Supervisor has been created.",
        ];
    }
}
