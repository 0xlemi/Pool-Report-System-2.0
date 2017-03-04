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
use App\Jobs\DeleteImageFromS3;
use App\Jobs\DeleteImagesFromS3;
use App\Image;
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

            if($user->isTechnician()){
                // since technician don't have email
                // should be immediately be verified
                $user->activated = 1;
            }
            $user->save();

            event(new UserRegistered($user));
        });
        WorkOrder::created(function ($workOrder){
            // create invoice
            $workOrder->invoices()->create([
                'amount' => $workOrder->price,
                'currency' => $workOrder->currency,
                'admin_id' => $workOrder->admin()->id,
            ]);
        });

        ServiceContract::created(function ($contract){
            // check invoice for date
            if($contract->checkIfTodayContractChargesInvoice()){
                $contract->invoices()->create([
                    'amount' => $contract->amount,
                    'currency' => $contract->currency,
                    'admin_id' => $contract->admin()->id,
                ]);
            }
        });

        Administrator::deleted(function ($admin){
            $user = $admin->user;
            dispatch(new DeleteImagesFromS3($admin->images));
            dispatch(new DeleteModels($user->notifications));
            $user->delete();
        });

        Report::deleted(function ($report){
            dispatch(new DeleteImagesFromS3($report->images));
        });

        WorkOrder::deleted(function ($workOrder){
            dispatch(new DeleteImagesFromS3($workOrder->images));
            foreach ($workOrder->invoices as $invoice) {
                $invoice->delete();
            }
        });
            Work::deleted(function ($work){
                dispatch(new DeleteImagesFromS3($work->images));
            });

        Service::deleted(function ($service){
            dispatch(new DeleteImagesFromS3($service->images));
        });
            Equipment::deleted(function ($equipment){
                dispatch(new DeleteImagesFromS3($equipment->images));
            });
            ServiceContract::deleted(function ($contract){
                foreach ($contract->invoices as $invoice) {
                    $invoice->delete();
                }
            });

        Client::deleted(function ($client){
            $user = $client->user;
            dispatch(new DeleteImagesFromS3($client->images));
            dispatch(new DeleteModels($user->notifications));
            $user->delete();
        });

        Supervisor::deleted(function ($supervisor){
            $user = $supervisor->user;
            dispatch(new DeleteImagesFromS3($supervisor->images));
            dispatch(new DeleteModels($user->notifications));
            $user->delete();
        });

        Technician::deleted(function ($technician){
            $user = $technician->user;
            dispatch(new DeleteImagesFromS3($technician->images));
            dispatch(new DeleteModels($user->notifications));
            $user->delete();
        });

        Image::deleted(function ($image){
            dispatch(new DeleteImageFromS3($image->big, $image->medium, $image->thumbnail, $image->icon));
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
