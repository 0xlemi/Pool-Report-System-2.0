<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\PRS\Traits\ControllerTrait;
use App\PRS\Transformers\Transformer;
use App\PRS\Transformers\ImageTransformer;
use App\Work;

/**
 * Transformer for the work class
 */
class WorkPreviewTransformer extends Transformer
{

    private $imageTransformer;

    public function __construct(ImageTransformer $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
    }


    public function transform(Work $work)
    {
        $photo = 'no image';
        if($work->imageExists()){
            $photo = $this->imageTransformer->transform($work->image(1, false));
        }

        return [
            'id' => $work->id,
            'title' => $work->title,
            'href' => url("api/v1/work/{$work->id}"),
            'photo' => $photo,
        ];
    }


}
