<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Report;
use App\PRS\Classes\UrlSigner;
use Carbon\Carbon;
use Storage;

class ServiceReportMail extends Mailable
{
    use Queueable, SerializesModels;

    private $report;
    private $user;
    private $urlSigner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Report $report, User $user)
    {
        $this->report = $report;
        $this->user = $user;
        $this->urlSigner = (new UrlSigner());
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
        $token = $this->urlSigner->create($this->user, 2);
        $data = array(
            'logo' => url('img/logo-2.png'),
            'headerImage' => url('img/uploads/email_header.png'),
            'name' => $name,
            'address' => $this->report->service()->address_line,
            'time' => $time,
            'photo1' => Storage::url($this->report->image(1)),
            'photo2' => Storage::url($this->report->image(2)),
            'photo3' => Storage::url($this->report->image(3)),
            'unsubscribeLink' => url('/unsubscribe').'/'.$token,
        );

        return $this->from('no-reply@poolreportsystem.com')
                    ->subject('Your pool is clean '.$name)
                    ->view('emails.serviceReport')
                    ->with($data);


    }
}
