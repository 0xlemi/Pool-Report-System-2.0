<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\WorkOrder;
use App\PRS\Helpers\NotificationHelpers;

class NewWorkOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $workOrder;
    protected $user;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(WorkOrder $workOrder, $user)
    {
        $this->workOrder = $workOrder;
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
        if($notifiable->notificationSettings->hasPermission('notify_workorder_created', 'database')){
            $channels[] = 'database';
        }if($notifiable->notificationSettings->hasPermission('notify_workorder_created', 'mail')){
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
        $workOrder = $this->workOrder;

        $person =  $this->helper->userStyled($this->user);
        return [
            'icon' => \Storage::url($workOrder->icon()),
            'link' => "workorders/{$workOrder->seq_id}",
            'title' => "New <strong>Work Order</strong> was created",
            'message' => "New <strong>Work Order</strong>
                            (<a href=\"../workorders/{$workOrder->seq_id}\">{$workOrder->title}</a>)
                            has been created by {$person}.",
        ];
    }
}
