<?php

namespace App\PRS\Observers;

use App\Work;
use App\Jobs\DeleteImagesFromS3;
use App\Notifications\AddedWorkNotification;

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
        $authUser = \Auth::user();
        $admin = $work->workOrder->admin();
        $workOrder = $work->workOrder;

        $admin->user->notify(new AddedWorkNotification($work, $authUser));
        $workOrder->supervisor->user->notify(new AddedWorkNotification($work, $authUser));
        foreach ($workOrder->service->clients as $client) {
            $client->user->notify(new AddedWorkNotification($work, $authUser));
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
