<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Supervisor;
use App\User;
use App\PRS\Helpers\NotificationHelpers;
use Carbon\Carbon;
use Storage;
use App\UserRoleCompany;

class NewSupervisorMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $supervisor;
    protected $userRoleCompany;
    protected $helper;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Supervisor $supervisor, UserRoleCompany $userRoleCompany, NotificationHelpers $helper)
    {
        $this->supervisor = $supervisor;
        $this->userRoleCompany = $userRoleCompany;
        $this->helper = $helper;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $supervisor = $this->supervisor;
        $loginSigner = $this->userRoleCompany->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(3)
        ]);
        $unsubscribeSigner = $this->userRoleCompany->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(10)
        ]);
        $person =  $this->helper->personStyled($this->userRoleCompany);
        $location = "supervisors/{$supervisor->seq_id}";

        $image = Storage::url('images/assets/email/eye.png');
        if($this->supervisor->imageExists()){
            $image = Storage::url($this->supervisor->normalImage(1));
        }

        $data = [
                    'logo' => Storage::url('images/assets/app/logo-2.png'),
                    'objectImage' => $image,
                    'title' => "New Supervisor Created!",
                    'moreInfo' => "The supervisor {$supervisor->name} {$supervisor->last_name} was created by {$person}",
                    'magicLink' => url("/signin/{$loginSigner->token}?location={$location}"),
                    'unsubscribeLink' => url('/unsubscribe').'/'.$unsubscribeSigner->token,
                ];

        return $this->subject('New Supervisor Created')
                    ->view('emails.newObject')
                    ->with($data);
    }
}
