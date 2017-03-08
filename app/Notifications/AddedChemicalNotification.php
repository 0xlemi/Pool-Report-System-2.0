<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Chemical;
use App\PRS\Helpers\NotificationHelpers;

class AddedChemicalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $chemical;
    protected $user;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Chemical $chemical, $user)
    {
        $this->chemical = $chemical;
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
        $channels = [];
        if($notifiable->notificationSettings->hasPermission('notify_chemical_added', 'database')){
            $channels[] = 'database';
        }if($notifiable->notificationSettings->hasPermission('notify_chemical_added', 'mail')){
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
        $service = $this->chemical->service;
        $person =  $helper->userStyled($this->user);
        return [
            'icon' => \Storage::url($service->icon()),
            'title' => "New <strong>Chemical</strong> was added to <strong>Service</strong> \"{$service->seq_id} {$service->name}\"",
            'message' => "New <strong>Chemical</strong> has been added to the <strong>Service</strong>
                            (<a href=\"../services/{$service->seq_id}\">{$service->name}</a>) by {$person}.",
        ];
    }
}
