<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\ServiceContract;
use App\PRS\Helpers\NotificationHelpers;

class AddedContractNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $contract;
    protected $user;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ServiceContract $contract, $user)
    {
        $this->contract = $contract;
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
        return $this->helper->channels($notifiable, 'notify_contract_added');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return null;    
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
        $person =  $this->helper->userStyled($this->user);
        return [
            'icon' => \Storage::url($service->icon()),
            'link' => "services/{$service->seq_id}",
            'title' => "New <strong>Contract</strong> for <strong>Service</strong> \"{$service->seq_id} {$service->name}\"",
            'message' => "Opened a new <strong>Contract</strong> for the <strong>Service</strong>
                            (<a href=\"../services/{$service->seq_id}\">{$service->name}</a>) by {$person}.",
        ];
    }
}
