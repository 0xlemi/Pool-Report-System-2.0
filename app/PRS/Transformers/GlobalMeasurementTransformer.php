<?php

namespace App\PRS\Transformers;

use App\GlobalMeasurement;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\LabelTransformer;


/**
 * Transformer for the report class
 */
class GlobalMeasurementTransformer extends Transformer
{
    protected $imageTransformer;
    protected $labelTransformer;

    public function __construct(ImageTransformer $imageTransformer,
                                    LabelTransformer $labelTransformer)
    {
        $this->imageTransformer = $imageTransformer;
        $this->labelTransformer = $labelTransformer;
    }

    /**
     * Transform GlobalMeasurement to api friendly array
     * @param  GlobalMeasurement $globalProduct
     * @return array
     */
    public function transform(GlobalMeasurement $globalProduct)
    {
        return [
            'id' => $globalProduct->seq_id,
            'name'=> $globalProduct->name,
            'labels' => $this->labelTransformer->transformCollection($globalProduct->labels),
            'photos' => $this->imageTransformer->transformCollection($globalProduct->images),
        ];
    }


}
