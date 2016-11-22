<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Client;

class NewClientNotification extends Notification
{
    use Queueable;

    protected $client;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
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
        $client = $this->client;
        return [
            'icon' => url($client->icon()),
            'link' => "clients/{$client->seq_id}",
            'title' => "New <strong>Client</strong> was created",
            'message' => "New <strong>Client</strong> (<a href=\"../clients/{$client->seq_id}\">{$client->name} {$client->last_name}</a>) has been created.",
        ];
    }
}
