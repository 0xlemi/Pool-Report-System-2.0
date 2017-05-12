<?php

namespace App\PRS\Transformers;

use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\PreviewTransformers\TechnicianPreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\UserRoleCompanyPreviewTransformer;

use Auth;
use App\Technician;
use App\Work;

/**
 * Transformer for the technician class
 */
class WorkTransformer extends Transformer
{

    private $imageTransformer;
    private $urcTransformer;

    public function __construct(ImageTransformer $imageTransformer,
                                UserRoleCompanyPreviewTransformer $urcTransformer)
    {
        $this->imageTransformer = $imageTransformer;
        $this->urcTransformer = $urcTransformer;
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
            'person' => $this->urcTransformer->transform($work->userRoleCompany),
            'photos' => $photos,
        ];
    }
}
