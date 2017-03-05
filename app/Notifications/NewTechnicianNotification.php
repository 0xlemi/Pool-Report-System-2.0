<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Technician;

class NewTechnicianNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $technician;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Technician $technician, User $user)
    {
        $this->technician = $technician;
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
        if($notifiable->notificationSettings->hasPermission('notify_technician_created', 'database')){
            $channels[] = 'database';
        }if($notifiable->notificationSettings->hasPermission('notify_technician_created', 'mail')){
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
        $url = url('/login');

        return (new MailMessage)
                    ->greeting('Technician was Created!')
                    ->line('A new technician has been created!')
                    ->action('Check New Techinican ', $url)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $technician = $this->technician;
        $userable = $this->user->userable();
        $type = $this->user->type;
        $urlName = $type->url();

        $person =  "<strong>System Administrator</strong>";
        if(!$this->user->isAdministrator()){
            $person = "<strong>{$type}</strong> (<a href=\"../{$urlName}/{$userable->seq_id}\">{$this->user->fullName}</a>)";
        }
        return [
            'icon' => url($technician->icon()),
            'link' => "technicians/{$technician->seq_id}",
            'title' => "New <strong>Technician</strong> was created",
            'message' => "New <strong>Technician</strong>
                            (<a href=\"../technicians/{$technician->seq_id}\">{$technician->name} {$technician->last_name}</a>)
                            has been created by {$person}.",
        ];
    }
}
