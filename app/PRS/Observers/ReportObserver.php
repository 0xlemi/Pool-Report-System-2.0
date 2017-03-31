<?php

namespace App\PRS\Observers;

use App\Report;
use App\Notifications\NewReportNotification;
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
        // $authUser = \Auth::user();
        // $admin = $report->admin();
        //
        // $admin->user->notify(new NewReportNotification($report, $authUser));
        // $report->technician->supervisor->user->notify(new NewReportNotification($report, $authUser));
        // foreach ($report->service->clients as $client) {
        //     $client->user->notify(new NewReportNotification($report, $authUser));
        // }
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
