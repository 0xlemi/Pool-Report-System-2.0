<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Work;
use App\PRS\Helpers\NotificationHelpers;
use App\UserRoleCompany;

class AddedWorkNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $work;
    protected $userRoleCompany;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Work $work, UserRoleCompany $userRoleCompany)
    {
        $this->work = $work;
        $this->userRoleCompany = $userRoleCompany;
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
        return $this->helper->channels($notifiable, 'notify_work_added');
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
        $workOrder = $this->work->workOrder;
        $person =  $this->helper->personStyled($this->userRoleCompany);
        return [
            'icon' => \Storage::url($this->work->icon()),
            'title' => "A new <strong>Work</strong> was added to <strong>Work Order</strong> \"{$workOrder->seq_id} {$workOrder->title}\"",
            'message' => "New <strong>Work</strong> was added to the <strong>Work Order</strong>
                            (<a href=\"../workorders/{$workOrder->seq_id}\">{$workOrder->title}</a>) by {$person}.",
        ];
    }
}
