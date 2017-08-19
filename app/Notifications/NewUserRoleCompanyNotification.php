<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\NewTechnicianMail;
use App\Mail\NewClientMail;
use App\Mail\NewSupervisorMail;
use App\UserRoleCompany;
use App\PRS\Helpers\NotificationHelpers;

class NewUserRoleCompanyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $userRoleCompany;
    protected $urc;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UserRoleCompany $userRoleCompany, UserRoleCompany $urc)
    {
        $this->userRoleCompany = $userRoleCompany;
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
        if($this->userRoleCompany->isRole('client')){
            return $this->helper->channels($notifiable, 'notify_client_created');
        }
        elseif($this->userRoleCompany->isRole('sup')){
            return $this->helper->channels($notifiable, 'notify_supervisor_created');
        }
        elseif($this->userRoleCompany->isRole('tech')){
            return $this->helper->channels($notifiable, 'notify_technician_created');
        }
        return [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if($this->userRoleCompany->isRole('client')){
            return (new NewClientMail($this->userRoleCompany, $notifiable, $this->urc, $this->helper))
                        ->to($notifiable->email)
                        ->bcc(env('MAIL_BCC'));
        }
        elseif($this->userRoleCompany->isRole('sup')){
            return (new NewSupervisorMail($this->userRoleCompany, $notifiable, $this->urc, $this->helper))
                        ->to($notifiable->email)
                        ->bcc(env('MAIL_BCC'));
        }
        elseif($this->userRoleCompany->isRole('tech')){
            return (new NewTechnicianMail($this->userRoleCompany, $notifiable, $this->urc, $this->helper))
                        ->to($notifiable->email)
                        ->bcc(env('MAIL_BCC'));
        }
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
        // Dont need to wory about company admin test case
        // because there are not going to be any channels
        $userRoleCompany = $this->userRoleCompany;
        $role = $userRoleCompany->role;

        $person =  $this->helper->personStyled($this->urc);
        return [
            'icon' => \Storage::url($userRoleCompany->icon()),
            'link' => "{$role->route}/{$userRoleCompany->seq_id}",
            'title' => "New <strong>{$role->text}</strong> was created",
            'message' => "New <strong>{$role->text}</strong> (<a href=\"../{$role->route}/{$userRoleCompany->seq_id}\">{$userRoleCompany->user->fullName}</a>)
                            has been created by {$person}.",
        ];
    }
}
