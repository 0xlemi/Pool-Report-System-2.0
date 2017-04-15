<?php

namespace App\PRS\Observers;

use App\Service;
use App\Notifications\NewServiceNotification;
use App\Jobs\DeleteImagesFromS3;

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
        $user = auth()->user();
        $people = $user->selectedUser->company->userRoleCompanies()->ofRole('admin', 'supervisor');
        foreach ($people as $person){
            $person->notify(new NewServiceNotification($service, $user));
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
