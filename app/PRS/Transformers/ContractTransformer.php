<?php

namespace App\PRS\Transformers;

use App\ServiceContract;

/**
 * Transformer for the ServiceContract class
 */
class ContractTransformer extends Transformer
{

    public function transform(ServiceContract $contract)
    {
        $serviceDays = $contract->serviceDays()->asArray();

        return [
            'active' => ($contract->active) ? true : false,
            'amount' => $contract->amount,
            'currency' => $contract->currency,
            'start_time' => $contract->start_time,
            'end_time' => $contract->end_time,
            'service_days' => [
                'monday' => $serviceDays['monday'],
                'tuesday' => $serviceDays['tuesday'],
                'wednesday' => $serviceDays['wednesday'],
                'thursday' => $serviceDays['thursday'],
                'friday' => $serviceDays['friday'],
                'saturday' => $serviceDays['saturday'],
                'sunday' => $serviceDays['sunday'],
            ],
            'comments' => $contract->comments,
        ];
        
    }

}
