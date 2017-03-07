<?php

namespace App\PRS\Transformers\FrontEnd\DataTables;

use App\PRS\Transformers\Transformer;
use App\Service;


/**
 * Transformer for the service class
 */
class TodaysRouteDatatableTransformer extends Transformer
{


    /**
     * Transform service for today's route to datatable friendly array
     * @param  service $service
     * @return array
     */
    public function transform(Service $service)
    {
        $contract = $service->serviceContract;
        return [
            'id' => $service->seq_id,
            'name' => $service->name,
            'address' => $service->address_line,
            'endTime' => $contract->EndTime()->colored(),
            'price' => $contract->amount.' <strong>'.$contract->currency.'</strong>',
        ];
    }

}
