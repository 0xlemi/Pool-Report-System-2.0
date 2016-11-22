<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\ServiceContract;

class AddedContractNotification extends Notification
{
    use Queueable;

    protected $contract;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ServiceContract $contract)
    {
        $this->contract = $contract;
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
        $service = $this->contract->service;
        return [
            'icon' => url($service->icon()),
            'link' => "services/{$service->seq_id}",
            'title' => "New <strong>Contract</strong> for <strong>Service</strong> \"{$service->seq_id} {$service->name}\"",
            'message' => "Opened a new <strong>Contract</strong> for the <strong>Service</strong> (<a href=\"../services/{$service->seq_id}\">{$service->name}</a>).",
        ];
    }
}
