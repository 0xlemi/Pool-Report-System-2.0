<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Supervisor;

class NewSupervisorNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $supervisor;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Supervisor $supervisor, User $user)
    {
        $this->supervisor = $supervisor;
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
        if($notifiable->notificationSettings->hasPermission('notify_supervisor_created', 'database')){
            $channels[] = 'database';
        }if($notifiable->notificationSettings->hasPermission('notify_supervisor_created', 'mail')){
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
        $supervisor = $this->supervisor;
        $userable = $this->user->userable();
        $type = $this->user->type;
        $urlName = $type->url();

        $person =  "<strong>System Administrator</strong>";
        if(!$this->user->isAdministrator()){
            $person = "<strong>{$type}</strong> (<a href=\"../{$urlName}/{$userable->seq_id}\">{$this->user->fullName}</a>)";
        }
        return [
            'icon' => url($supervisor->icon()),
            'link' => "supervisors/{$supervisor->seq_id}",
            'title' => "New <strong>Supervisor</strong> was created",
            'message' => "New <strong>Supervisor</strong>
                            (<a href=\"../supervisors/{$supervisor->seq_id}\">{$supervisor->name} {$supervisor->last_name}</a>)
                            has been created by {$person}.",
        ];
    }
}
