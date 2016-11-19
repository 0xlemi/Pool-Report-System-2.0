<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Payment;

class NewPaymentNotification extends Notification
{
    use Queueable;

    protected $payment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $payment = $this->payment;
        $invoice = $payment->invoice;
        return [
            'link' => "invoices/{$invoice->seq_id}",
            'title' => "A new <strong>Payment</strong> was added to <strong>Invoice</strong> (#{$invoice->seq_id})",
            'message' => "New <strong>Payment</strong> for <strong>{$payment->amount} {$payment->invoice->currency}</strong> was added to the <strong>Invoice</strong> (<a href=\"../invoices/{$invoice->seq_id}\">#{$invoice->seq_id}</a>).",
        ];
    }
}
