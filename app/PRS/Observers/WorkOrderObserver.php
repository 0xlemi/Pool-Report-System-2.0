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

        $admin = $workOrder->admin();
        $admin->user->notify(new NewWorkOrderNotification($workOrder, \Auth::user()));
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
