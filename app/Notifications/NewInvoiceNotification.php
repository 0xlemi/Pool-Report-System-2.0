<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Invoice;
use App\PRS\Helpers\NotificationHelpers;
use Storage;
use App\Mail\NewInvoiceMail;

class NewInvoiceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $invoice;
    protected $helper;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
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
        return $this->helper->channels($notifiable, 'notify_invoice_created');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new NewInvoiceMail($this->invoice->admin(), $notifiable, $this->invoice->invoiceable->service, $this->invoice))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $invoice = Invoice::findOrFail($this->invoice->id);

        return [
            'icon' => Storage::url('images/assets/app/notifications-button.png'),
            'link' => "invoices/{$invoice->seq_id}",
            'title' => "New <strong>Invoice</strong> (#{$invoice->seq_id}) was created",
            'message' => "New <strong>Invoice</strong> (<a href=\"../invoices/{$invoice->seq_id}\">#{$invoice->seq_id}</a>)
                            for <strong>{$invoice->amount} {$invoice->currency}</strong> has been created on a
                            <strong>{$invoice->type()}</strong>",
        ];
    }
}
