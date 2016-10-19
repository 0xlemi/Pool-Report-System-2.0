<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\Supervisor;


use App\PRS\Traits\ControllerTrait;

use App\PRS\Transformers\Transformer;
use App\PRS\Transformers\ImageTransformer;

/**
 * Transformer for the service class
 */
class SupervisorPreviewTransformer extends Transformer
{

    use ControllerTrait;

    private $imageTransformer;

    public function __construct(ImageTransformer $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
    }


    public function transform(Supervisor $supervisor)
    {
        $photo = 'no image';
        if($supervisor->imageExists()){
            $photo = $this->imageTransformer->transform($supervisor->image(1, false));
        }

        return [
            'id' => $supervisor->seq_id,
            'name' => $supervisor->name,
            'last_name' => $supervisor->last_name,
            'status' => $supervisor->user()->active,
            'href' => url("api/v1/supervisors/{$supervisor->seq_id}?api_token={$this->getUser()->api_token}"),
            'photo' => $photo,
        ];
    }


}
