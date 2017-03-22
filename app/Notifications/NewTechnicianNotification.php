<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Technician;
use App\PRS\Helpers\NotificationHelpers;
use App\Mail\NewTechnicianMail;
use Carbon\Carbon;
use Storage;
use Mail;

class NewTechnicianNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $technician;
    protected $user;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Technician $technician, $user)
    {
        $this->technician = $technician;
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
        return $this->helper->channels($notifiable, 'notify_technician_created');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new NewTechnicianMail($this->technician, $notifiable, $this->helper))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $technician = $this->technician;

        $person =  $this->helper->userStyled($this->user);
        return [
            'icon' => \Storage::url($technician->icon()),
            'link' => "technicians/{$technician->seq_id}",
            'title' => "New <strong>Technician</strong> was created",
            'message' => "New <strong>Technician</strong>
                            (<a href=\"../technicians/{$technician->seq_id}\">{$technician->name} {$technician->last_name}</a>)
                            has been created by {$person}.",
        ];
    }
}
