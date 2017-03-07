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
        $admin = $work->workOrder->admin();
        $admin->user->notify(new AddedWorkNotification($work, \Auth::user()));
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
