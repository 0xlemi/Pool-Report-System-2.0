<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\PRS\Transformers\Transformer;
use App\WorkOrder;

/**
 * Transformer for the work order class
 */
class WorkOrderPreviewTransformer extends Transformer
{

    public function transform(WorkOrder $workOrder)
    {
        return [
            'id' => $workOrder->seq_id,
            'title' => $workOrder->title,
            'href' => url("api/v1/workorders/{$workOrder->seq_id}"),
        ];
    }


}
