<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\ServiceContract;

class AddedContractNotification extends Notification
{
    use Queueable;

    protected $contract;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ServiceContract $contract, User $user)
    {
        $this->contract = $contract;
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
        if($notifiable->notificationSettings->hasPermission('notify_contract_added', 'database')){
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
        $service = $this->contract->service;
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
            'title' => "New <strong>Contract</strong> for <strong>Service</strong> \"{$service->seq_id} {$service->name}\"",
            'message' => "Opened a new <strong>Contract</strong> for the <strong>Service</strong>
                            (<a href=\"../services/{$service->seq_id}\">{$service->name}</a>) by {$person}.",
        ];
    }
}
