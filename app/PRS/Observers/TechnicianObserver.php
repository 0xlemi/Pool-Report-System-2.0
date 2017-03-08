<?php

namespace App\PRS\Observers;

use App\Technician;
use App\Jobs\DeleteModels;
use App\Jobs\DeleteImagesFromS3;
use App\Notifications\NewTechnicianNotification;

class TechnicianObserver
{
    /**
     * Listen to the Technician created event.
     *
     * @param  Technician  $technician
     * @return void
     */
    public function created(Technician $technician)
    {
        $admin = $technician->admin();
        $admin->user->notify(new NewTechnicianNotification($technician, \Auth::user()));
    }

    /**
     * Listen to the Technician deleting event.
     *
     * @param  Technician  $technician
     * @return void
     */
    public function deleted(Technician $technician)
    {
        $user = $technician->user;
        dispatch(new DeleteImagesFromS3($technician->images));
        dispatch(new DeleteModels($user->notifications));
        $user->delete();
    }
}