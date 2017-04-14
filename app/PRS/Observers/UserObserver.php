<?php

namespace App\PRS\Observers;

use App\User;
use App\Events\UserRegistered;

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
        // *** this needs to be verification token
        // $token = $user->activationToken()->create([
        //     'token' => str_random(128),
        // ]);

        // use different type of authorization for api
        // $user->api_token = str_random(60);
        $user->remember_token = str_random(10);

        event(new UserRegistered($user));
    }
}
