<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Work;
use App\PRS\Helpers\NotificationHelpers;

class AddedWorkNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $work;
    protected $user;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Work $work, $user)
    {
        $this->work = $work;
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
        if($notifiable->notificationSettings->hasPermission('notify_work_added', 'database')){
            $channels[] = 'database';
        }if($notifiable->notificationSettings->hasPermission('notify_work_added', 'mail')){
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
        $workOrder = $this->work->workOrder;
        $person =  $this->helper->userStyled($this->user);
        return [
            'icon' => \Storage::url($work->icon()),
            'title' => "A new <strong>Work</strong> was added to <strong>Work Order</strong> \"{$workOrder->seq_id} {$workOrder->title}\"",
            'message' => "New <strong>Work</strong> was added to the <strong>Work Order</strong>
                            (<a href=\"../workorders/{$workOrder->seq_id}\">{$workOrder->title}</a>) by {$person}.",
        ];
    }
}
