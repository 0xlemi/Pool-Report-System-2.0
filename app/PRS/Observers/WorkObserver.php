<?php

namespace App\PRS\Observers;

use App\Work;
use App\Jobs\DeleteImagesFromS3;
use App\Notifications\AddedWorkNotification;
use App\PRS\Classes\Logged;

class WorkObserver
{
    /**
     * Listen to the Work created event.
     *
     * @param  Work  $work
     * @return void
     */
    public function created(Work $work)
    {
        // Notifications
        $urc = Logged::user()->selectedUser;
        $people = $urc->company->userRoleCompanies()->ofRole('admin', 'supervisor')->get();
        foreach ($people as $person){
            $person->notify(new AddedWorkNotification($work, $urc));
        }
        foreach ($work->workOrder->service->userRoleCompanies as $client) {
            $client->notify(new AddedWorkNotification($work, $urc));
        }
    }

    /**
     * Listen to the Work deleting event.
     *
     * @param  Work  $work
     * @return void
     */
    public function deleted(Work $work)
    {
        dispatch(new DeleteImagesFromS3($work->images));
    }
}
