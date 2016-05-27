<?php

namespace App\PRS\Transformers;

use App\Service;

use App\PRS\Helpers\ServiceHelpers;

/**
 * Transformer for the service class
 */
class ServiceTransformer extends Transformer
{

    private $serviceHelpers;

    public function __construct(ServiceHelpers $serviceHelpers)
    {
        $this->serviceHelpers = $serviceHelpers;
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
            'status' => $service->status,
            'comments' => $service->comments,
            'icon_photo' => $service->icon(),
            'thumbnail_photo' => $service->thumbnail(),
            'normal_photo' => $service->image(),
        ];
    }


}
