<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Report;
use Carbon\Carbon;
use Storage;

class ServiceReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $report;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Report $report, User $user)
    {
        $this->report = $report;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $time = (new Carbon($this->report->completed, 'UTC'))
                    ->setTimezone($this->report->admin()->timezone)
                    ->toDayDateTimeString();

        // info needed by the template
        $name = $this->user->userable()->name;
        $loginSigner = $this->user->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(10)
        ]);
        $unsubscribeSigner = $this->user->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(10)
        ]);
        $data = array(
            'logo' => url('img/logo-2.png'),
            'headerImage' => url('img/uploads/email_header.png'),
            'name' => $name,
            'address' => $this->report->service->address_line,
            'time' => $time,
            'photo1' => Storage::url($this->report->normalImage(1)),
            'photo2' => Storage::url($this->report->normalImage(2)),
            'photo3' => Storage::url($this->report->normalImage(3)),
            'loginLink' => url('/signin').'/'.$loginSigner->token,
            'unsubscribeLink' => url('/unsubscribe').'/'.$unsubscribeSigner->token,
        );

        return $this->from('no-reply@poolreportsystem.com')
                    ->subject('Your pool is clean '.$name)
                    ->view('emails.serviceReport')
                    ->with($data);


    }
}
