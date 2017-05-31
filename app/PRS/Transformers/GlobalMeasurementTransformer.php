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
     * @param  GlobalMeasurement $globalMeasurement
     * @return array
     */
    public function transform(GlobalMeasurement $globalMeasurement)
    {
        return [
            'id' => $globalMeasurement->seq_id,
            'name'=> $globalMeasurement->name,
            'labels' => $this->labelTransformer->transformCollection($globalMeasurement->labels),
            'photos' => $this->imageTransformer->transformCollection($globalMeasurement->images),
        ];
    }


}
