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

        

        // $token = $user->activationToken()->create([
        //     'token' => str_random(128),
        // ]);
        //
        // $user->api_token = str_random(60);
        // $user->remember_token = str_random(10);
        //
        // if($user->isTechnician()){
        //     // since technician don't have email
        //     // should be immediately be verified
        //     $user->verified = 1;
        // }
        // $user->save();
        //
        // event(new UserRegistered($user));
    }
}
