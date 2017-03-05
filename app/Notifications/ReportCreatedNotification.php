<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\ServiceReportMail;
use App\Channels\RealMailChannel;
use App\Report;


class ReportCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $report;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Report $report, User $user)
    {
        $this->report = $report;
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
        $channels = [];
        if($notifiable->notificationSettings->hasPermission('notify_report_created', 'database')){
            $channels[] = 'database';
        }if($notifiable->notificationSettings->hasPermission('notify_report_created', 'mail')){
        $channels[] = RealMailChannel::class;
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toRealMail($notifiable)
    {
        return (new ServiceReportMail($this->report, $notifiable));
    }



    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $report = $this->report;
        $userable = $this->user->userable();
        $type = $this->user->type;
        $urlName = $type->url();

        $person =  "<strong>System Administrator</strong>";
        if(!$this->user->isAdministrator()){
            $person = "<strong>{$type}</strong> (<a href=\"../{$urlName}/{$userable->seq_id}\">{$this->user->fullName}</a>)";
        }
        return [
            'icon' => \Storage::url($report->icon()),
            'link' => "reports/{$report->seq_id}",
            'title' => "New <strong>Report</strong> was created",
            'message' => "New <strong>Report</strong>
                            (<a href=\"../reports/{$report->seq_id}\">{$report->title}</a>)
                            has been created by {$person}.",
        ];
    }
}
