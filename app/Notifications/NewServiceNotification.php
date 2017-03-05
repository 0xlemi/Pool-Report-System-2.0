<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Service;

class NewServiceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $service;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Service $service, User $user)
    {
        $this->service = $service;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [];
        if($notifiable->notificationSettings->hasPermission('notify_service_created', 'database')){
        $channels[] = 'database';
        }
        return $channels;
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
        $userable = $this->user->userable();
        $type = $this->user->type;
        $urlName = $type->url();

        $person =  "<strong>System Administrator</strong>";
        if(!$this->user->isAdministrator()){
            $person = "<strong>{$type}</strong> (<a href=\"../{$urlName}/{$userable->seq_id}\">{$this->user->fullName}</a>)";
        }
        return [
            'icon' => url($service->icon()),
            'link' => "services/{$service->seq_id}",
            'title' => "New <strong>Service</strong> was created",
            'message' => "New <strong>Service</strong> (<a href=\"../services/{$service->seq_id}\">{$service->name}</a>)
                            has been created by {$person}.",
        ];
    }
}
