<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Supervisor;
use App\PRS\Helpers\NotificationHelpers;
use App\Mail\NewSupervisorMail;
use App\UserRoleCompany;

class NewSupervisorNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $supervisor;
    protected $userRoleCompany;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Supervisor $supervisor, UserRoleCompany $userRoleCompany)
    {
        $this->supervisor = $supervisor;
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
        return $this->helper->channels($notifiable, 'notify_supervisor_created');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new NewSupervisorMail($this->supervisor, $notifiable, $this->helper))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $supervisor = $this->supervisor;

        $person =  $this->helper->personStyled($this->userRoleCompany);
        return [
            'icon' => \Storage::url($supervisor->icon()),
            'link' => "supervisors/{$supervisor->seq_id}",
            'title' => "New <strong>Supervisor</strong> was created",
            'message' => "New <strong>Supervisor</strong>
                            (<a href=\"../supervisors/{$supervisor->seq_id}\">{$supervisor->name} {$supervisor->last_name}</a>)
                            has been created by {$person}.",
        ];
    }
}
