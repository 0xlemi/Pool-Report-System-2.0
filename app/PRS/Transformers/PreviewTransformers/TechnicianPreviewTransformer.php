<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\PRS\Transformers\Transformer;
use App\PRS\Transformers\ImageTransformer;
use App\Technician;

/**
 * Transformer for the service class
 */
class TechnicianPreviewTransformer extends Transformer
{

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
            'photo' => $photo,
        ];
    }


}
