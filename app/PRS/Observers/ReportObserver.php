<?php

namespace App\PRS\Observers;

use App\Report;
use App\Notifications\ReportCreatedNotification;
use App\Jobs\DeleteImagesFromS3;

class ReportObserver
{
    /**
     * Listen to the Report created event.
     *
     * @param  Report  $report
     * @return void
     */
    public function created(Report $report)
    {
        $admin = $report->admin();
        $admin->user->notify(new ReportCreatedNotification($report, \Auth::user()));
    }

    /**
     * Listen to the Report deleting event.
     *
     * @param  Report  $report
     * @return void
     */
    public function deleted(Report $report)
    {
        dispatch(new DeleteImagesFromS3($report->images));
    }
}
