<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Client;
use App\PRS\Helpers\NotificationHelpers;
use App\Mail\NewClientMail;
use App\UserRoleCompany;

class NewClientNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $client;
    protected $userRoleCompany;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Client $client, UserRoleCompany $userRoleCompany)
    {
        $this->client = $client;
        $this->userRoleCompany = $userRoleCompany;
        $this->helper = new NotificationHelpers();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->helper->channels($notifiable, 'notify_client_created');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new NewClientMail($this->client, $notifiable, $this->helper))->to($notifiable->email);
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

        $person =  $this->helper->personStyled($this->userRoleCompany);
        return [
            'icon' => \Storage::url($client->icon()),
            'link' => "clients/{$client->seq_id}",
            'title' => "New <strong>Client</strong> was created",
            'message' => "New <strong>Client</strong> (<a href=\"../clients/{$client->seq_id}\">{$client->name} {$client->last_name}</a>)
                            has been created by {$person}.",
        ];
    }
}
