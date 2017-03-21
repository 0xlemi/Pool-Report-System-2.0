<?php

namespace App\PRS\Observers;

use App\Service;
use App\Notifications\NewServiceNotification;
use App\Jobs\DeleteImagesFromS3;

class ServiceObserver
{
    /**
     * Listen to the Service created event.
     *
     * @param  Service  $service
     * @return void
     */
    public function created(Service $service)
    {
        $authUser = \Auth::user();
        $admin = $service->admin();
        $admin->user->notify(new NewServiceNotification($service, $authUser));
        foreach ($admin->supervisors as $supervisor) {
            $supervisor->user->notify(new NewServiceNotification($service, $authUser));
        }
    }

    /**
     * Listen to the Service deleting event.
     *
     * @param  Service  $service
     * @return void
     */
    public function deleted(Service $service)
    {
        dispatch(new DeleteImagesFromS3($service->images));
    }
}
