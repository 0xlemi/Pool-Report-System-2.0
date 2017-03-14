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

    private $token;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, User $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'token' => $this->token
        ];
        return $this->from('no-reply@poolreportsystem.com')
                    ->subject('Password Reset')
                    ->view('emails.auth.resetPassword')
                    ->with($data);
    }
}
