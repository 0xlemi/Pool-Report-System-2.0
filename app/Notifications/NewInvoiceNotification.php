<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Invoice;

class NewInvoiceNotification extends Notification
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
        $invoice = $this->invoice;
        return [
            'link' => "invoices/{$invoice->seq_id}",
            'title' => "New invoice (#{$invoice->seq_id}) was created",
            'message' => "New invoice (#{$invoice->seq_id}) for {$invoice->amount} {$invoice->currency} has been created on a {$invoice->type()}.",
        ];
    }
}
