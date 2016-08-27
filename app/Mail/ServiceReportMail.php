<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Report;
use Carbon\Carbon;

class ServiceReportMail extends Mailable
{
    use Queueable, SerializesModels;

    private $report;
    private $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Report $report, string $name)
    {
        $this->report = $report;
        $this->name = $name;
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
        $data = array(
            'logo' => url('img/logo-2.png'),
            'headerImage' => url('img/uploads/email_header.png'),
            'name' => $this->name,
            'address' => $this->report->service()->address_line,
            'time' => $time,
            'photo1' => url($this->report->image(1)),
            'photo2' => url($this->report->image(2)),
            'photo3' => url($this->report->image(3)),
        );

        return $this->from('service@poolreportsystem.com')
                    ->subject('Your pool is clean '.$this->name)
                    ->view('emails.serviceReport')
                    ->with($data);


    }
}
