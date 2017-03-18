<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Payment;
use App\Invoice;
use App\PRS\Helpers\NotificationHelpers;
use Storage;

class NewPaymentNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    protected $payment;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
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
        // return $this->helper->channels($notifiable, 'notify_payment_created');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

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
        $invoice = Invoice::findOrFail($payment->invoice->id);

        return [
            'icon' => Storage::url('images/assets/app/notifications-button.png'),
            'link' => "invoices/{$invoice->seq_id}",
            'title' => "A new <strong>Payment</strong> was added to <strong>Invoice</strong> (#{$invoice->seq_id})",
            'message' => "New <strong>Payment</strong> for <strong>{$payment->amount} {$payment->invoice->currency}</strong>
                            was added to the <strong>Invoice</strong>
                            (<a href=\"../invoices/{$invoice->seq_id}\">#{$invoice->seq_id}</a>).",
        ];
    }
}
