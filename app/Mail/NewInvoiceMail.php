<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Service;
use App\Invoice;
use App\UserRoleCompany;
use App\Administrator;
use Carbon\Carbon;

class NewInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $userRoleCompany;
    public $service;
    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Administrator $admin, UserRoleCompany $userRoleCompany, Service $service, Invoice $invoice)
    {
        $this->admin = $admin;
        $this->userRoleCompany = $userRoleCompany;
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
        $loginSigner = $this->userRoleCompany->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(3)
        ]);
        $location = "invoices/{$this->invoice->seq_id}";
        $unsubscribeSigner = $this->userRoleCompany->urlSigners()->create([
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
