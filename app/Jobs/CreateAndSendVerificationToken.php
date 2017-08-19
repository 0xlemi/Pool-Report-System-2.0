<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\UserRoleCompany;
use App\Mail\SendVerificationToken;
use App\Mail\WelcomeVerificationMail;

class CreateAndSendVerificationToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRoleCompany;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UserRoleCompany $userRoleCompany)
    {
        $this->userRoleCompany = $userRoleCompany;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send verification token
        $token = $this->userRoleCompany->verificationToken()->create([
            'token' => str_random(128),
        ]);

        if($this->userRoleCompany->isRole('admin')){
            Mail::to($this->userRoleCompany->user)
                    ->bcc(env('MAIL_BCC'))
                    ->send(new SendVerificationToken($token));
        }
        elseif($this->userRoleCompany->isRole('client', 'sup', 'tech')){
            Mail::to($this->userRoleCompany->user)
                    ->bcc(env('MAIL_BCC'))
                    ->send(new WelcomeVerificationMail($token, $this->userRoleCompany->company));
        }
    }
}
