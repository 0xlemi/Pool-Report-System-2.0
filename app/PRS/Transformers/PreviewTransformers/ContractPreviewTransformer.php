<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\PRS\Transformers\Transformer;
use App\PRS\Classes\Logged;
use App\ServiceContract;
use App\WorkOrder;

/**
 * Transformer for the ServiceContract class
 */
class ContractPreviewTransformer extends Transformer
{

    private $logged;

    public function __construct(Logged $logged)
    {
        $this->logged = $logged;
    }

    public function transform(ServiceContract $contract)
    {
        $service = $contract->service;
        return [
            'service_id' => $service->seq_id,
            'amount' => $contract->amount,
            'active' => ($contract->active) ? true : false,
            'href' => url("api/v1/services/{$service->seq_id}/contract?api_token={$this->logged->user()->api_token}"),
        ];
    }

}
