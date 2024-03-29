<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class ResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
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
        $magicLink = url('password/reset').'/'.$this->token;
        $data = [
            'magicLink' => $magicLink,
            'magicLinkWithBreaks' => wordwrap($magicLink, 50, '<br>', true)
        ];
        return $this->subject("Password Reset")
                ->view('emails.auth.resetPassword')
                ->with($data);
    }
}
