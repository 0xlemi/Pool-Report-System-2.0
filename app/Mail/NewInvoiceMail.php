<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Service;
use App\Invoice;
use App\Company;
use App\UserRoleCompany;
use Carbon\Carbon;

class NewInvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $company;
    public $notifiable;
    public $service;
    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Company $company, UserRoleCompany $notifiable, Service $service, Invoice $invoice)
    {
        $this->company = $company;
        $this->notifiable = $notifiable;
        $this->service = $service;
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $loginSigner = $this->notifiable->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(3)
        ]);
        $location = "invoices/{$this->invoice->seq_id}";
        $unsubscribeSigner = $this->notifiable->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(10)
        ]);

        $title = (string) $this->invoice->type();
        if($workOrderTitle = $this->invoice->invoiceable->title){
            $title .= ' - '.$workOrderTitle ;
        }
        return $this->subject($this->invoice->type().' Invoice')
                ->view('emails.invoice')
                ->with([
                    'title' => $title,
                    'magicLink' => url("/signin/{$loginSigner->token}?location={$location}"),
                    'unsubscribeLink' => url('/unsubscribe').'/'.$unsubscribeSigner->token,
                ]);
    }
}
