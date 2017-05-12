<?php

namespace App\PRS\Observers;

use App\Report;
use App\Notifications\NewReportNotification;
use App\Jobs\DeleteImagesFromS3;
use App\PRS\Classes\Logged;

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
        // Notifications
        $urc = Logged::user()->selectedUser;
        $people = $urc->company->userRoleCompanies()->ofRole('admin', 'supervisor')->get();
        foreach ($people as $person){
            $person->notify(new NewReportNotification($report, $urc));
        }
        foreach ($report->service->userRoleCompanies as $client) {
            $client->notify(new NewReportNotification($report, $urc));
        }
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
