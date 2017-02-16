<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\Supervisor;


use App\PRS\Traits\ControllerTrait;
use App\PRS\Transformers\Transformer;
use App\PRS\Transformers\ImageTransformer;
use App\Client;

/**
 * Transformer for the service class
 */
class ClientPreviewTransformer extends Transformer
{

    use ControllerTrait;

    private $imageTransformer;

    public function __construct(ImageTransformer $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
    }


    public function transform(Client $client)
    {
        $photo = 'no image';
        if($client->imageExists()){
            $photo = $this->imageTransformer->transform($client->image(1, false));
        }

        return [
            'id' => $client->seq_id,
            'name' => $client->name,
            'last_name' => $client->last_name,
            'type' => ($client->type == 1) ? 'Owner' : 'House Admin',
            'href' => url("api/v1/clients/{$client->seq_id}?api_token={$this->getUser()->api_token}"),
            'photo' => $photo,
        ];
    }


}
