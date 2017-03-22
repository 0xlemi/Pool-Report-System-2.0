<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Mail\SendActivationToken;
use App\Mail\WelcomeActivationMail;

class SendActivationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle($event)
    {
        if($event->user->isAdministrator()){
            Mail::to($event->user)->send(new SendActivationToken($event->user->activationToken));
        }
        elseif(!$event->user->isTechnician()){
            $admin = $event->user->userable()->admin();
            Mail::to($event->user)->send(new WelcomeActivationMail($event->user->activationToken, $admin));
        }
    }
}
