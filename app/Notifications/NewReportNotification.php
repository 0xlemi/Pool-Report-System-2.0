<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\NewReportMail;
use App\Report;
use App\User;
use App\PRS\Helpers\NotificationHelpers;
use App\UserRoleCompany;


class NewReportNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $report;
    private $userRoleCompany;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Report $report, UserRoleCompany $userRoleCompany)
    {
        $this->report = $report;
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
        return $this->helper->channels($notifiable, 'notify_report_created');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new NewReportMail($this->report, $notifiable))->to($notifiable->email);
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
        $person =  $this->helper->personStyled($this->userRoleCompany);
        return [
            'icon' => \Storage::url($report->icon()),
            'link' => "reports/{$report->seq_id}",
            'title' => "New <strong>Report</strong> was created",
            'message' => "New <strong>Report</strong>
                            (<a href=\"../reports/{$report->seq_id}\">{$report->seq_id}</a>)
                            has been created by {$person}.",
        ];
    }
}
