<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\Service;

use App\PRS\Transformers\Transformer;
use App\PRS\Transformers\ImageTransformer;

/**
 * Transformer for the service class
 */
class ServicePreviewTransformer extends Transformer
{

    private $imageTransformer;

    public function __construct(ImageTransformer $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
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
            'href' => url("api/v1/services/{$service->seq_id}"),
            'photo' => $photo,
        ];
    }


}
