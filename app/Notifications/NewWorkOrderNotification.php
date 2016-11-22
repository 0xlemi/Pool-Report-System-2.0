<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\WorkOrder;

class NewWorkOrderNotification extends Notification
{
    use Queueable;

    protected $workOrder;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(WorkOrder $workOrder, User $user)
    {
        $this->workOrder = $workOrder;
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
        $workOrder = $this->workOrder;
        $userable = $this->user->userable();
        $type = $this->user->type();
        $urlName = $type->url();

        $person =  "<strong>System Administrator</strong>";
        if(!$this->user->isAdministrator()){
            $person = "<strong>{$type}</strong> (<a href=\"../{$urlName}/{$userable->seq_id}\">{$this->user->fullName}</a>)";
        }
        return [
            'icon' => url($workOrder->icon()),
            'link' => "workorders/{$workOrder->seq_id}",
            'title' => "New <strong>Work Order</strong> was created",
            'message' => "New <strong>Work Order</strong>
                            (<a href=\"../workorders/{$workOrder->seq_id}\">{$workOrder->title}</a>)
                            has been created by {$person}.",
        ];
    }
}
