<?php

namespace App\PRS\Observers;

use App\Supervisor;
use App\Notifications\NewSupervisorNotification;
use App\Jobs\DeleteModels;
use App\Jobs\DeleteImagesFromS3;

class SupervisorObserver
{
    /**
     * Listen to the Supervisor created event.
     *
     * @param  Supervisor  $supervisor
     * @return void
     */
    public function created(Supervisor $supervisor)
    {
        $admin = $supervisor->admin();
        $admin->user->notify(new NewSupervisorNotification($supervisor, \Auth::user()));
    }

    /**
     * Listen to the Supervisor deleting event.
     *
     * @param  Supervisor  $supervisor
     * @return void
     */
    public function deleted(Supervisor $supervisor)
    {
        $user = $supervisor->user;
        dispatch(new DeleteImagesFromS3($supervisor->images));
        dispatch(new DeleteModels($user->notifications));
        $user->delete();
    }
}
