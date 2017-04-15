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
        // Notifications
        $user = auth()->user();
        $people = $user->selectedUser->company->userRoleCompanies()->ofRole('admin', 'supervisor');
        foreach ($people as $person){
            $person->notify(new NewReportNotification($report, $user));
        }
        foreach ($report->service->userRoleCompanies as $client) {
            $client->notify(new NewReportNotification($report, $user));
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
