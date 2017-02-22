<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Mail\SendActivationToken;
use App\User;
use Mail;
use App\Events\UserRegistered;
use App\ServiceContract;
use App\Client;
use App\Administrator;
use App\Supervisor;
use App\Technician;
use App\Jobs\DeleteModels;

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

        Administrator::deleted(function ($admin){
            $user = $admin->user;
            dispatch(new DeleteModels($user->notifications));
            $user->delete();
        });
        Supervisor::deleted(function ($supervisor){
            $user = $supervisor->user;
            dispatch(new DeleteModels($user->notifications));
            $user->delete();
        });
        Technician::deleted(function ($technician){
            $user = $technician->user;
            dispatch(new DeleteModels($user->notifications));
            $user->delete();
        });
        Client::deleted(function ($client){
            $user = $client->user;
            dispatch(new DeleteModels($user->notifications));
            $user->delete();
        });
        ServiceContract::deleted(function ($contract){
            foreach ($contract->invoices as $invoice) {
                $invoice->delete();
            }
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
