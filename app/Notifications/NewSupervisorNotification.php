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
        $supervisor = $this->supervisor;
        return [
            'link' => "supervisors/{$supervisor->seq_id}",
            'title' => "New <strong>Supervisor</strong> was created",
            'message' => "New <strong>Supervisor</strong> (<a href=\"../supervisors/{$supervisor->seq_id}\">{$supervisor->name} {$supervisor->last_name}</a>) has been created.",
        ];
    }
}
