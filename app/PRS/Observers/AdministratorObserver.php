<?php

namespace App\PRS\Observers;

use App\Administrator;
use App\Jobs\DeleteModels;
use App\Jobs\DeleteImagesFromS3;

class AdministratorObserver
{

    /**
     * Listen to the App\Administrator deleting event.
     *
     * @param  App\Administrator  $admin
     * @return void
     */
    public function deleting(Administrator $admin)
    {
        // Cancel Stripe Subscription
        if ($admin->subscribed('main')) {
            $admin->subscription('main')->cancelNow();
        }

        // Delete associated objects
        foreach ($admin->clients as $client) {
            $client->delete();
        }
        foreach ($admin->supervisors as $supervisor) {
            $supervisor->delete();
        }
        foreach ($admin->services as $service) {
            $service->delete();
        }
    }

    /**
     * Listen to the App\Administrator deleting event.
     *
     * @param  App\Administrator  $admin
     * @return void
     */
    public function deleted(Administrator $admin)
    {
        $user = $admin->user;
        dispatch(new DeleteImagesFromS3($admin->images));
        dispatch(new DeleteModels($user->notifications));
        $user->delete();
    }
}
