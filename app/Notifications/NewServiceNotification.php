<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Service;
use App\PRS\Helpers\NotificationHelpers;
use App\Mail\NewServiceMail;

class NewServiceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $service;
    protected $user;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Service $service, $user)
    {
        $this->service = $service;
        $this->user = $user;
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
        return $this->helper->channels($notifiable, 'notify_service_created');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new NewServiceMail($this->service, $this->user, $this->helper))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $service = $this->service;

        $person =  $this->helper->userStyled($this->user);
        return [
            'icon' => \Storage::url($service->icon()),
            'link' => "services/{$service->seq_id}",
            'title' => "New <strong>Service</strong> was created",
            'message' => "New <strong>Service</strong> (<a href=\"../services/{$service->seq_id}\">{$service->name}</a>)
                            has been created by {$person}.",
        ];
    }
}
