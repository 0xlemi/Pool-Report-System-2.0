<?php

namespace App\PRS\Observers;

use App\Service;
use App\Notifications\NewServiceNotification;
use App\Jobs\DeleteImagesFromS3;
use App\Jobs\DeviceMagic\CreateOrUpdateForm;
use App\PRS\Classes\Logged;
use App\PRS\Classes\DeviceMagic\Form;
use App\PRS\Classes\DeviceMagic\ReportForm;
use App\PRS\Classes\DeviceMagic\Destination;

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
        $this->updateDeviceMagicServiceList();
    }

    /**
     * Listen to the Service created event.
     *
     * @param  Service  $service
     * @return void
     */
    public function updated(Service $service)
    {
        $this->updateDeviceMagicServiceList();
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
        $this->updateDeviceMagicServiceList();
    }

    /**
     * Update the service list in the mobile app
     * @return void
     */
    protected function updateDeviceMagicServiceList()
    {
        $company = Logged::company();
        $destination = new Destination($company);
        $form = new ReportForm($destination);
        dispatch(new CreateOrUpdateForm($form));
    }
}
