<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Service;
use App\User;
use App\PRS\Helpers\NotificationHelpers;
use Carbon\Carbon;
use Storage;

class NewServiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $service;
    protected $user;
    protected $helper;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Service $service, User $user, NotificationHelpers $helper)
    {
        $this->service = $service;
        $this->user = $user;
        $this->helper = $helper;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $service = $this->service;
        $loginSigner = $this->user->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(3)
        ]);
        $unsubscribeSigner = $this->user->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(10)
        ]);
        $person =  $this->helper->userStyled($this->user);
        $location = "services/{$service->seq_id}";

        $image = url('img/email/house.png');
        if($this->service->imageExists()){
            $image = Storage::url($this->service->normalImage(1));
        }

        $data = [
                    'logo' => url('img/logo-2.png'),
                    'objectImage' => $image,
                    'title' => "New Service Created!",
                    'moreInfo' => "The service {$service->name} was created by {$person}",
                    'magicLink' => url("/signin/{$loginSigner->token}?location={$location}"),
                    'unsubscribeLink' => url('/unsubscribe').'/'.$unsubscribeSigner->token,
                ];

        return $this->from('no-reply@poolreportsystem.com')
                    ->subject('New Service Created')
                    ->view('emails.newObject')
                    ->with($data);
    }
}