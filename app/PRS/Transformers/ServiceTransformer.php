<?php

namespace App\PRS\Transformers;

use App\Service;

use App\PRS\Helpers\ServiceHelpers;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\ContractTransformer;
use App\PRS\Transformers\EquipmentTransformer;
use App\PRS\Classes\Logged;

/**
 * Transformer for the service class
 */
class ServiceTransformer extends Transformer
{

    private $imageTransformer;
    private $contractTransformer;
    private $logged;

    public function __construct(
                        ImageTransformer $imageTransformer,
                        ContractTransformer $contractTransformer,
                        Logged $logged)
    {
        $this->imageTransformer = $imageTransformer;
        $this->contractTransformer = $contractTransformer;
        $this->logged = $logged;
    }

    /**
     * Transform Service into api friendly array
     * @param  Service $service
     * @return array
     * tested
     */
    public function transform(Service $service)
    {

        $photo = 'no image';
        if($service->imageExists()){
            $photo = $this->imageTransformer->transform($service->image(1, false));
        }

        $contract = 'no contract';
        if($service->hasServiceContract()){
            $contract = $this->contractTransformer->transform($service->serviceContract);
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
            'location' =>
                [
                    'latitude' => $service->latitude,
                    'longitude' => $service->longitude,
                ],
            'photo' => $photo,
            'contract' => $contract,
            'equipment' => [
                'number' => $service->equipment()->count(),
                'href' => url("api/v1/services/{$service->seq_id}/equipment?api_token={$this->logged->user()->api_token}"),
            ],
        ];
    }


}
