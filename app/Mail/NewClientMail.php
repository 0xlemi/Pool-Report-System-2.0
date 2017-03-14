<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Client;
use App\User;
use App\PRS\Helpers\NotificationHelpers;
use Carbon\Carbon;
use Storage;

class NewClientMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $client;
    protected $user;
    protected $helper;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Client $client, User $user, NotificationHelpers $helper)
    {
        $this->client = $client;
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
        $client = $this->client;
        $loginSigner = $this->user->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(3)
        ]);
        $unsubscribeSigner = $this->user->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(10)
        ]);
        $person =  $this->helper->userStyled($this->user);
        $location = "clients/{$client->seq_id}";

        $image = url('img/email/new_user.png');
        if($this->client->imageExists()){
            $image = Storage::url($this->client->normalImage(1));
        }

        $data = [
                    'logo' => url('img/logo-2.png'),
                    'objectImage' => $image,
                    'title' => "New Client Created!",
                    'moreInfo' => "The client {$client->name} {$client->last_name} was created by {$person}",
                    'magicLink' => url("/signin/{$loginSigner->token}?location={$location}"),
                    'unsubscribeLink' => url('/unsubscribe').'/'.$unsubscribeSigner->token,
                ];

        return $this->from('no-reply@poolreportsystem.com')
                    ->subject('New Client Created')
                    ->view('emails.newObject')
                    ->with($data);
    }
}
