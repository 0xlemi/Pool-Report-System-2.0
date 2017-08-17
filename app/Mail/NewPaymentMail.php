<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Storage;
use App\UserRoleCompany;
use App\Payment;
use App\User;

class NewPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $payment;
    protected $userRoleCompany;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Payment $payment, UserRoleCompany $userRoleCompany)
    {
        $this->payment = $payment;
        $this->userRoleCompany = $userRoleCompany;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $payment = $this->payment;
        $invoice = $payment->invoice;
        $loginSigner = $this->userRoleCompany->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(3)
        ]);
        $unsubscribeSigner = $this->userRoleCompany->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(10)
        ]);
        $location = "invoices/{$invoice->seq_id}";

        $data = [
                    'logo' => Storage::url('images/assets/app/logo-2.png'),
                    'objectImage' => Storage::url('images/assets/email/money.png'),
                    'title' => "Payment has been registered!",
                    'moreInfo' => "<strong>Payment (#{$payment->seq_id})</strong> for <strong>{$payment->amount}{$invoice->currency}</strong><br>Registered in {$payment->created_at} for the <strong>invoice (#{$invoice->seq_id})</strong>.",
                    'magicLink' => url("/signin/{$loginSigner->token}?location={$location}"),
                    'unsubscribeLink' => url('/unsubscribe').'/'.$unsubscribeSigner->token,
                ];

        return $this->subject('Payment Registered')
                    ->view('emails.newObject')
                    ->with($data);
    }
}
