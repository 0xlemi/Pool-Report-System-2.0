<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\ServiceReportMail;
use App\Channels\RealMailChannel;
use App\Report;


class ReportCreatedNotification extends Notification
{
    use Queueable;

    private $report;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [RealMailChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toRealMail($notifiable)
    {
        return (new ServiceReportMail($this->report, $notifiable->userable()->name));
    }



    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}