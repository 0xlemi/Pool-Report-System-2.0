<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Equipment;
use App\PRS\Helpers\NotificationHelpers;
use App\UserRoleCompany;

class AddedEquipmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $equipment;
    protected $userRoleCompany;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Equipment $equipment, UserRoleCompany $userRoleCompany)
    {
        $this->equipment = $equipment;
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
        return $this->helper->channels($notifiable, 'notify_equipment_added');
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
        $service = $this->equipment->service();
        $person =  $this->helper->personStyled($this->userRoleCompany);

        return [
            'icon' => \Storage::url($this->equipment->icon()),
            'title' => "New <strong>Equipment</strong> was added to <strong>Service</strong> \"{$service->seq_id} {$service->name}\"",
            'message' => "New <strong>Equipment</strong> was added to the <strong>Service</strong>
                            (<a href=\"../services/{$service->seq_id}\">{$service->name}</a>) by {$person}.",
        ];
    }
}
