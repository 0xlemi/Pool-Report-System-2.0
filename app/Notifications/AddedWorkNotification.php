<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Work;

class AddedWorkNotification extends Notification
{
    use Queueable;

    protected $work;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Work $work)
    {
        $this->work = $work;
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
        $workOrder = $this->work->workOrder;
        return [
            'title' => "A new work was added",
            'message' => "New work was added to {$workOrder->title} work order.",
        ];
    }
}
