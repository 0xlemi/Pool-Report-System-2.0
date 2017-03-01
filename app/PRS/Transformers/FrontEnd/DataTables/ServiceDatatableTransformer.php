<?php

namespace App\PRS\Transformers\FrontEnd\DataTables;

use App\PRS\Transformers\Transformer;
use App\Service;

/**
 * Transformer for the service class
 */
class ServiceDatatableTransformer extends Transformer
{

    /**
     * Transform Service to api friendly array
     * @param  Service $service
     * @return array
     */
    public function transform(Service $service)
    {
        $serviceDays = "<span class=\"label label-pill label-default\">No Contract</span>";
        $price = "<span class=\"label label-pill label-default\">No Contract</span>";
        if($service->hasServiceContract()){
            $serviceDays = $service->serviceContract->serviceDays()->shortNamesStyled();
            $price = $service->serviceContract->amount.' <strong>'.$service->serviceContract->currency.'</strong>';
        }
        return [
            'id' => $service->seq_id,
            'name' => $service->name,
            'address' => $service->address_line,
            'serviceDays' => $serviceDays,
            'price' => $price,
        ];
    }

}
