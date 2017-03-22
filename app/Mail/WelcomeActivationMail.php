<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Administrator;
use App\ActivationToken;

class WelcomeActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ActivationToken $token, Administrator $admin)
    {
        $this->token = $token;
        $this->admin = $admin;
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
