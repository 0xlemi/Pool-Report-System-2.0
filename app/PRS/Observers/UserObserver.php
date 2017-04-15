<?php

namespace App\PRS\Observers;

use App\User;

class UserObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        // use different type of authorization for api
        // $user->api_token = str_random(60);
        $user->remember_token = str_random(10);
        $user->save();
    }
}
