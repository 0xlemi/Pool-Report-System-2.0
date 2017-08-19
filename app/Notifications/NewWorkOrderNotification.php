<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\WorkOrder;
use App\PRS\Helpers\NotificationHelpers;
use App\Mail\NewWorkOrderMail;
use App\UserRoleCompany;

class NewWorkOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $workOrder;
    protected $urc;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(WorkOrder $workOrder, UserRoleCompany $urc)
    {
        $this->workOrder = $workOrder;
        $this->urc = $urc;
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
        return $this->helper->channels($notifiable, 'notify_workorder_created');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new NewWorkOrderMail($this->workOrder, $notifiable, $this->urc, $this->helper))
                    ->to($notifiable->email)
                    ->bcc(env('MAIL_BCC'));
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

        $person =  $this->helper->personStyled($this->urc);
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
