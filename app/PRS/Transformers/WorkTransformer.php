<?php

namespace App\PRS\Transformers;

use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\PreviewTransformers\TechnicianPreviewTransformer;

use Auth;
use App\Technician;
use App\Work;

/**
 * Transformer for the technician class
 */
class WorkTransformer extends Transformer
{

    private $imageTransformer;
    private $technicianPreviewTransformer;

    public function __construct(ImageTransformer $imageTransformer,
                                TechnicianPreviewTransformer $technicianPreviewTransformer)
    {
        $this->imageTransformer = $imageTransformer;
        $this->technicianPreviewTransformer = $technicianPreviewTransformer;
    }

    /**
     * Tranform Work into api friendly array
     * @param  Work   $work
     * @return array
     * tested
     */
    public function transform(Work $work)
    {
        $photos = [];
        if($work->numImages() > 0){
            $photos = $this->imageTransformer->transformCollection($work->images()->get());
        }

        return [
            'id' => $work->id,
            'title' => $work->title,
            'description' => $work->description,
            'quantity' => $work->quantity,
            'units' => $work->units,
            'cost' => $work->cost,
            'currency' => $work->workOrder->currency,
            'technician' => $this->technicianPreviewTransformer->transform($work->technician),
            'photos' => $photos,
        ];
    }
}
