<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Chemical;

class AddedChemicalNotification extends Notification
{
    use Queueable;

    protected $chemical;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Chemical $chemical)
    {
        $this->chemical = $chemical;
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
        $service = $this->chemical->service;
        return [
            'title' => "New <strong>Chemical</strong> was added to <strong>Service</strong> \"{$service->seq_id} {$service->name}\"",
            'message' => "New <strong>Chemical</strong> has been added to the <strong>Service</strong> (<a href=\"../services/{$service->seq_id}\">{$service->name}</a>).",
        ];
    }
}
