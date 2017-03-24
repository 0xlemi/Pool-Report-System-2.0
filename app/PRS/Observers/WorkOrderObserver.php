<?php

namespace App\PRS\Observers;

use App\WorkOrder;
use App\Notifications\NewWorkOrderNotification;
use App\Jobs\DeleteImagesFromS3;

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
        // create invoice
        $workOrder->invoices()->create([
            'amount' => $workOrder->price,
            'currency' => $workOrder->currency,
            'description' => $workOrder->description,
            'admin_id' => $workOrder->admin()->id,
        ]);

        $authUser = \Auth::user();
        $admin = $workOrder->admin();

        $admin->user->notify(new NewWorkOrderNotification($workOrder, $authUser));
        foreach ($admin->supervisors as $supervisor) {
            $supervisor->user->notify(new NewWorkOrderNotification($workOrder, $authUser));
        }
        foreach ($workOrder->service->clients as $client) {
            $client->user->notify(new NewWorkOrderNotification($workOrder, $authUser));
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
