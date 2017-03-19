<?php

namespace App\PRS\Observers;

use App\Client;
use App\Notifications\NewClientNotification;
use App\Jobs\DeleteModels;
use App\Jobs\DeleteImagesFromS3;

class ClientObserver
{
    /**
     * Listen to the Client created event.
     *
     * @param  Client  $client
     * @return void
     */
    public function created(Client $client)
    {
        // Notify Admin, Supervisors, Technicians
        $admin = $client->admin();
        $admin->user->notify(new NewClientNotification($client, \Auth::user()));
    }

    /**
     * Listen to the Client deleting event.
     *
     * @param  Client  $client
     * @return void
     */
    public function deleted(Client $client)
    {
        $user = $client->user;
        dispatch(new DeleteImagesFromS3($client->images));
        dispatch(new DeleteModels($user->notifications));
        $user->delete();
    }
}
