<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Invoice;

class NewInvoiceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $invoice;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
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
        if($notifiable->notificationSettings->hasPermission('notify_invoice_created', 'database')){
        $channels[] = 'database';
        }
        return $channels;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $invoice = $this->invoice;

        return [
            'icon' => url('img/notifications-button.png'),
            'link' => "invoices/{$invoice->seq_id}",
            'title' => "New <strong>Invoice</strong> (#{$invoice->seq_id}) was created",
            'message' => "New <strong>Invoice</strong> (<a href=\"../invoices/{$invoice->seq_id}\">#{$invoice->seq_id}</a>)
                            for <strong>{$invoice->amount} {$invoice->currency}</strong> has been created on a
                            <strong>{$invoice->type()}</strong>",
        ];
    }
}
