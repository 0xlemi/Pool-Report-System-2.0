<?php

namespace App\Listeners;

use App\Events\UserRoleCompanyRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\SendVerificationToken;
use App\Mail\WelcomeVerificationMail;

class SendVerificationEmail
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
        $userRoleCompany = $event->userRoleCompany;
        // Means the User was just created and needs verification
        if($userRoleCompany->user->userRoleCompanies()->count() == 1){
            // Send verification token
            $token = $userRoleCompany->verificationToken()->create([
                'token' => str_random(128),
            ]);

            if($userRoleCompany->isRole('admin')){
                Mail::to($userRoleCompany->user)->send(new SendVerificationToken($token));
            }
            if($userRoleCompany->isRole('client', 'sup', 'tech')){
                Mail::to($userRoleCompany->user)->send(new WelcomeVerificationMail($token, $userRoleCompany->company));
            }
            
        }
    }
}
