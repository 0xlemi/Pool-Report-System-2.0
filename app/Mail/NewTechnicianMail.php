<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Technician;
use App\PRS\Helpers\NotificationHelpers;
use Carbon\Carbon;
use Storage;
use App\UserRoleCompany;

class NewTechnicianMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $technician;
    protected $userRoleCompany;
    protected $helper;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Technician $technician, UserRoleCompany $userRoleCompany, NotificationHelpers $helper)
    {
        $this->technician = $technician;
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
        $technician = $this->technician;
        $loginSigner = $this->userRoleCompany->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(3)
        ]);
        $unsubscribeSigner = $this->userRoleCompany->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(10)
        ]);
        $person =  $this->helper->personStyled($this->userRoleCompany);
        $location = "technicians/{$technician->seq_id}";

        $image = Storage::url('images/assets/email/wrench.png');
        if($this->technician->imageExists()){
            $image = Storage::url($this->technician->normalImage(1));
        }

        $data = array(
                    'logo' => Storage::url('images/assets/app/logo-2.png'),
                    'objectImage' => $image,
                    'title' => "New Technician Created!",
                    'moreInfo' => "The technician {$technician->name} {$technician->last_name} was created by {$person}",
                    'magicLink' => url("/signin/{$loginSigner->token}?location={$location}"),
                    'unsubscribeLink' => url('/unsubscribe').'/'.$unsubscribeSigner->token,
                );

        return $this->subject('New Technician Created')
                    ->view('emails.newObject')
                    ->with($data);
    }
}
