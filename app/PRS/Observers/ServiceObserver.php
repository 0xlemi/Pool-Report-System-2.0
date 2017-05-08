<?php

namespace App\PRS\Observers;

use App\Service;
use App\Notifications\NewServiceNotification;
use App\Jobs\DeleteImagesFromS3;
use App\PRS\Classes\Logged;

class ServiceObserver
{
    /**
     * Listen to the Service created event.
     *
     * @param  Service  $service
     * @return void
     */
    public function created(Service $service)
    {
        // Notifications
        $urc = Logged::user()->selectedUser;
        $people = $urc->company->userRoleCompanies()->ofRole('admin', 'supervisor')->get();
        foreach ($people as $person){
            $person->notify(new NewServiceNotification($service, $urc));
        }
    }

    /**
     * Listen to the App\Service deleting event.
     *
     * @param  Service  $service
     * @return void
     */
    public function deleting(Service $service)
    {
        foreach ($service->reports as $report) {
            $report->delete();
        }
        foreach ($service->workOrders as $workOrder) {
            $workOrder->delete();
        }
        foreach ($service->equipment as $equipment) {
            $equipment->delete();
        }
        if($service->hasServiceContract()){
            $service->serviceContract->delete();
        }
    }

    /**
     * Listen to the Service deleting event.
     *
     * @param  Service  $service
     * @return void
     */
    public function deleted(Service $service)
    {
        dispatch(new DeleteImagesFromS3($service->images));
    }
}
