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
    public function __construct(Service $service, $user)
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
        }if($notifiable->notificationSettings->hasPermission('notify_service_created', 'mail')){
            $channels[] = 'mail';
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

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

        $person =  "<strong>System Administrator</strong>";
        if($this->user == null){
            // there is no authenticated user (we are running a migration)
            $person =  "<strong>Unknown</strong>";
        }elseif(!$this->user->isAdministrator()){
            $userable = $this->user->userable();
            $type = $this->user->type;
            $urlName = $type->url();
            $person = "<strong>{$type}</strong> (<a href=\"../{$urlName}/{$userable->seq_id}\">{$this->user->fullName}</a>)";
        }
        return [
            'icon' => \Storage::url($service->icon()),
            'link' => "services/{$service->seq_id}",
            'title' => "New <strong>Service</strong> was created",
            'message' => "New <strong>Service</strong> (<a href=\"../services/{$service->seq_id}\">{$service->name}</a>)
                            has been created by {$person}.",
        ];
    }
}
