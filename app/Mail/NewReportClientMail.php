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
use App\UserRoleCompany;

class NewReportClientMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $report;
    private $notifiable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Report $report, UserRoleCompany $notifiable)
    {
        $this->report = $report;
        $this->notifiable = $notifiable;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $time = (new Carbon($this->report->completed, 'UTC'))
                    ->setTimezone($this->report->company->timezone)
                    ->toDayDateTimeString();

        // info needed by the template
        $name = $this->notifiable->user->name;
        $location = "reports/{$this->report->seq_id}";
        $loginSigner = $this->notifiable->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(10)
        ]);
        $unsubscribeSigner = $this->notifiable->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(10)
        ]);
        $magicLink =  url("/signin/{$loginSigner->token}?location={$location}");
        $data = array(
            'logo' => Storage::url('images/assets/app/logo-long.png'),
            'name' => $name,
            'address' => $this->report->service->address_line,
            'time' => $time,
            'photo1' => Storage::url($this->report->normalImage(1)),
            'photo2' => Storage::url($this->report->normalImage(2)),
            'photo3' => Storage::url($this->report->normalImage(3)),
            'magicLink' => $magicLink,
            'magicLinkWithBreaks' => wordwrap($magicLink, 50, '<br>', true),
            'unsubscribeLink' => url('/unsubscribe').'/'.$unsubscribeSigner->token,
        );

        return $this->subject('Your pool is clean '.$name)
                    ->view('emails.serviceReport')
                    ->with($data);


    }
}
