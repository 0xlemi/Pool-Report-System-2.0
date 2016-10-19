<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\PRS\Traits\ControllerTrait;
use App\PRS\Transformers\Transformer;
use App\PRS\Transformers\ImageTransformer;
use App\Technician;

/**
 * Transformer for the service class
 */
class TechnicianPreviewTransformer extends Transformer
{

    use ControllerTrait;

    private $imageTransformer;

    public function __construct(ImageTransformer $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
    }


    public function transform(Technician $technician)
    {
        $photo = 'no image';
        if($technician->imageExists()){
            $photo = $this->imageTransformer->transform($technician->image(1, false));
        }

        return [
            'id' => $technician->seq_id,
            'name' => $technician->name,
            'last_name' => $technician->last_name,
            'status' => $technician->user()->active,
            'href' => url("api/v1/technicians/{$technician->seq_id}?api_token={$this->getUser()->api_token}"),
            'photo' => $photo,
        ];
    }


}
