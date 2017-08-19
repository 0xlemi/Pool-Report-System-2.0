<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Company;
use App\VerificationToken;

class WelcomeVerificationMail extends Mailable implements ShouldQueue
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
        $data = [
            'company_name' => $this->company->name,
            'magicLink' => route('auth.activate', $this->token),
            'magicLinkWithBreaks' => wordwrap(route('auth.activate', $this->token), 50, '<br>', true)
        ];
        return $this->subject("{$this->company->name} is now using Pool Report System")
                ->view('emails.auth.welcome_activation')
                ->with($data);
    }
}
