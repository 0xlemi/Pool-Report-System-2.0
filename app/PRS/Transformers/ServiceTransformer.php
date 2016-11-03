<?php

namespace App\PRS\Transformers;

use App\Service;

use App\PRS\Helpers\ServiceHelpers;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\EquipmentTransformer;

use App\PRS\Traits\ControllerTrait;

/**
 * Transformer for the service class
 */
class ServiceTransformer extends Transformer
{

    use ControllerTrait;

    private $serviceHelpers;
    private $imageTransformer;
    private $equipmentTransformer;

    public function __construct(
                        ServiceHelpers $serviceHelpers,
                        ImageTransformer $imageTransformer,
                        EquipmentTransformer $equipmentTransformer)
    {
        $this->serviceHelpers = $serviceHelpers;
        $this->imageTransformer = $imageTransformer;
        $this->equipmentTransformer = $equipmentTransformer;
    }


    public function transform(Service $service)
    {

        $photo = 'no image';
        if($service->imageExists()){
            $photo = $this->imageTransformer->transform($service->image(1, false));
        }

        return [
            'id' => $service->seq_id,
            'name' => $service->name,
            'address_line' => $service->address_line,
            'city' => $service->city,
            'state' => $service->state,
            'postal_code' => $service->postal_code,
            'country' => $service->country,
            'comments' => $service->comments,
            'photo' => $photo,
            'equipment' => [
                'number' => $service->equipment()->count(),
                'href' => url("api/v1/services/{$service->seq_id}/equipment?api_token={$this->getUser()->api_token}"),
            ],
        ];
    }


}
