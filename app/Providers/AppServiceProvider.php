<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Mail\SendActivationToken;
use App\User;
use App\Work;
use Auth;
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
use App\Notifications\NewTechnicianNotification;
use App\Notifications\AddedWorkNotification;
use App\Notifications\NewClientNotification;
use App\Notifications\NewServiceNotification;
use App\Notifications\NewWorkOrderNotification;
use App\Notifications\ReportCreatedNotification;
use App\Notifications\AddedContractNotification;
use App\Notifications\NewSupervisorNotification;
use App\Notifications\AddedEquipmentNotification;
use App\PRS\Observers\UserObserver;
use App\PRS\Observers\AdministratorObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    // **********************
    //       Observers
    // **********************

    User::observe(UserObserver::class);
    Administrator::observe(AdministratorObserver::class);


    // **********************
    //       Created
    // **********************

        Report::created(function ($report){
            $admin = $report->admin();
            $admin->user->notify(new ReportCreatedNotification($report, Auth::user()));
        });

        WorkOrder::created(function ($workOrder){
            // create invoice
            $workOrder->invoices()->create([
                'amount' => $workOrder->price,
                'currency' => $workOrder->currency,
                'admin_id' => $workOrder->admin()->id,
            ]);

            $admin = $workOrder->admin();
            $admin->user->notify(new NewWorkOrderNotification($workOrder, Auth::user()));
        });
            Work::created(function ($work){
                $admin = $work->workOrder->admin();
                $admin->user->notify(new AddedWorkNotification($work, Auth::user()));
            });

        Service::created(function ($service){
            $admin = $service->admin();
            $admin->user->notify(new NewServiceNotification($service, Auth::user()));
        });
            Equipment::created(function ($equipment){
                $admin = $equipment->service()->admin();
                $admin->user->notify(new AddedEquipmentNotification($equipment, Auth::user()));
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
                $admin = $contract->admin();
                $admin->user->notify(new AddedContractNotification($contract, Auth::user()));
            });

        Client::created(function ($client){
            $admin = $client->admin();
            $admin->user->notify(new NewClientNotification($client, Auth::user()));
        });

        Supervisor::created(function ($supervisor){
            $admin = $supervisor->admin();
            $admin->user->notify(new NewSupervisorNotification($supervisor, Auth::user()));
        });

        Technician::created(function ($technician){
            $admin = $technician->admin();
            $admin->user->notify(new NewTechnicianNotification($technician, Auth::user()));
        });


    // **********************
    //       Deleted
    // **********************


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
