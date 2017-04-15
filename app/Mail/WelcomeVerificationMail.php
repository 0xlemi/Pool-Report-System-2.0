<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Company;
use App\VerificationToken;

class WelcomeVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VerificationToken $token, Company $company)
    {
        $this->token = $token;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.auth.welcome_activation');
    }
}
