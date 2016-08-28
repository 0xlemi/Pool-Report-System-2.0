<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Mail;

class RealMailChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if($notifiable->userable()->get_reports_emails){
            // Has permission to send email
            $message = Mail::to($notifiable)->send($notification->toRealMail($notifiable));
        }
        // Send notification to the $notifiable instance...
    }
}
