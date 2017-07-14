<?php

namespace App\PRS\Observers;

use App\WorkOrder;
use App\Notifications\NewWorkOrderNotification;
use App\Jobs\DeleteImagesFromS3;
use App\PRS\Classes\Logged;
use Carbon\Carbon;

class WorkOrderObserver
{
    /**
     * Listen to the WorkOrder created event.
     *
     * @param  WorkOrder  $workOrder
     * @return void
     */
    public function created(WorkOrder $workOrder)
    {
        $urc = Logged::user()->selectedUser;
        $company = $workOrder->company;

        // create invoice
        $workOrder->invoices()->create([
            'amount' => $workOrder->price,
            'currency' => $workOrder->currency,
            'description' => $workOrder->description,
            'pay_before' => Carbon::now()->addDays(20),
            'company_id' => $company->id,
        ]);

        $people = $company->userRoleCompanies()->ofRole('admin', 'supervisor')->get();
        foreach ($people as $person){
            $person->notify(new NewWorkOrderNotification($workOrder, $urc));
        }
        $clients = $workOrder->service->userRoleCompanies;
        foreach ($clients as $client) {
            $client->notify(new NewWorkOrderNotification($workOrder, $urc));
        }

    }

    /**
     * Listen to the App\WorkOrder deleting event.
     *
     * @param  WorkOrder  $service
     * @return void
     */
    public function deleting(WorkOrder $workOrder)
    {
        foreach ($workOrder->works as $work) {
            $work->delete();
        }
    }

    /**
     * Listen to the WorkOrder deleting event.
     *
     * @param  WorkOrder  $workOrder
     * @return void
     */
    public function deleted(WorkOrder $workOrder)
    {
        dispatch(new DeleteImagesFromS3($workOrder->images));
        foreach ($workOrder->invoices as $invoice) {
            $invoice->delete();
        }
    }
}
