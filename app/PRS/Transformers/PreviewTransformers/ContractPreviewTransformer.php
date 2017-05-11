<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\PRS\Transformers\Transformer;
use App\ServiceContract;
use App\WorkOrder;

/**
 * Transformer for the ServiceContract class
 */
class ContractPreviewTransformer extends Transformer
{

    public function transform(ServiceContract $contract)
    {
        $service = $contract->service;
        return [
            'service_id' => $service->seq_id,
            'active' => ($contract->active) ? true : false,
            'href' => url("api/v1/services/{$service->seq_id}/contract"),
        ];
    }

}
