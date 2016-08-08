<?php

namespace App\PRS\Transformers;

use App\Service;

use App\PRS\Helpers\ServiceHelpers;
use App\PRS\Transformers\ImageTransformer;

/**
 * Transformer for the service class
 */
class ServiceTransformer extends Transformer
{

    private $serviceHelpers;
    private $imageTransformer;

    public function __construct(
                        ServiceHelpers $serviceHelpers,
                        ImageTransformer $imageTransformer)
    {
        $this->serviceHelpers = $serviceHelpers;
        $this->imageTransformer = $imageTransformer;
    }


    public function transform(Service $service)
    {
        $service_days = $this->serviceHelpers->num_to_service_days($service->service_days);
        return [
            'id' => $service->seq_id,
            'name' => $service->name,
            'address_line' => $service->address_line,
            'city' => $service->city,
            'state' => $service->state,
            'postal_code' => $service->postal_code,
            'country' => $service->country,
            'type' => $service->type,
            'service_day_monday' => $service_days['monday'],
            'service_day_tuesday' => $service_days['tuesday'],
            'service_day_wednesday' => $service_days['wednesday'],
            'service_day_thursday' => $service_days['thursday'],
            'service_day_friday' => $service_days['friday'],
            'service_day_saturday' => $service_days['saturday'],
            'service_day_sunday' => $service_days['sunday'],
            'amount' => $service->amount,
            'currency' => $service->currency,
            'start_time' => $service->start_time,
            'end_time' => $service->end_time,
            'status' => ($service->status) ? true : false,
            'comments' => $service->comments,
            'photo' => $this->imageTransformer->transform($service->image(1, false)),

        ];
    }


}
