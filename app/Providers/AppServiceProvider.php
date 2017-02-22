<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Mail\SendActivationToken;
use App\User;
use Mail;
use App\Events\UserRegistered;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::created(function ($user) {
            $token = $user->activationToken()->create([
                'token' => str_random(128),
            ]);

            $user->api_token = str_random(60);
            $user->save();

            event(new UserRegistered($user));

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
