<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\VerificationToken;

class SendVerificationToken extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VerificationToken $token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'magicLink' => route('auth.activate', $this->token),
            'magicLinkWithBreaks' => wordwrap(route('auth.activate', $this->token), 50, '<br>', true)
        ];
        return $this->subject("Email Verification")
                ->view('emails.auth.activation')
                ->with($data);
    }
}
