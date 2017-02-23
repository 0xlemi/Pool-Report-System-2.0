<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Mail\SendActivationToken;
use App\User;
use App\Work;
use Mail;
use App\Events\UserRegistered;
use App\ServiceContract;
use App\Client;
use App\Report;
use App\Administrator;
use App\Supervisor;
use App\Technician;
use App\Jobs\DeleteModels;
use App\Jobs\DeleteImages;
use App\Service;
use App\WorkOrder;
use App\Equipment;

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
            dispatch(new DeleteImages($admin->images));
            dispatch(new DeleteModels($user->notifications));
            $user->delete();
        });

        Report::deleted(function ($report){
            dispatch(new DeleteImages($report->images));
        });

        WorkOrder::deleted(function ($workOrder){
            dispatch(new DeleteImages($workOrder->images));
            foreach ($workOrder->invoices as $invoice) {
                $invoice->delete();
            }
        });
            Work::deleted(function ($work){
                dispatch(new DeleteImages($work->images));
            });

        Service::deleted(function ($service){
            dispatch(new DeleteImages($service->images));
        });
            Equipment::deleted(function ($equipment){
                dispatch(new DeleteImages($equipment->images));
            });
            ServiceContract::deleted(function ($contract){
                foreach ($contract->invoices as $invoice) {
                    $invoice->delete();
                }
            });

        Client::deleted(function ($client){
            $user = $client->user;
            dispatch(new DeleteImages($client->images));
            dispatch(new DeleteModels($user->notifications));
            $user->delete();
        });

        Supervisor::deleted(function ($supervisor){
            $user = $supervisor->user;
            dispatch(new DeleteImages($supervisor->images));
            dispatch(new DeleteModels($user->notifications));
            $user->delete();
        });
        
        Technician::deleted(function ($technician){
            $user = $technician->user;
            dispatch(new DeleteImages($technician->images));
            dispatch(new DeleteModels($user->notifications));
            $user->delete();
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
