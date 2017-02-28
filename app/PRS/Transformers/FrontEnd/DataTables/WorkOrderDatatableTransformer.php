<?php

namespace App\PRS\Transformers\FrontEnd\DataTables;

use App\PRS\Traits\ControllerTrait;
use App\PRS\Transformers\Transformer;
use App\PRS\Classes\Logged;
use App\Supervisor;
use App\Service;
use App\WorkOrder;
use Carbon\Carbon;

/**
 * Transformer for the service class
 */
class WorkOrderDatatableTransformer extends Transformer
{


    /**
     * Transform WorkOrder to api friendly array
     * @param  WorkOrder $workOrder
     * @return array
     */
    public function transform(WorkOrder $workOrder)
    {
        $supervisor = $workOrder->supervisor;
        return [
            'id' => $workOrder->seq_id,
            'start' => $workOrder->start()
                            ->format('d M Y h:i:s A'),
            'end' =>  (string) $workOrder->end(),
            'price' => $workOrder->price.' <strong>'.$workOrder->currency.'</strong>',
            'service' => $workOrder->service->name,
            'supervisor' => $supervisor->name.' '.$supervisor->last_name,
        ];
    }

}
