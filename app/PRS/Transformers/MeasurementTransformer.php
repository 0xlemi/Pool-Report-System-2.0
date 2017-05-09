<?php

namespace App\PRS\Transformers;
use App\Measurement;
use App\PRS\Transformers\GlobalMeasurementTransformer;


/**
 * Transformer for the Measurement class
 */
class MeasurementTransformer extends Transformer
{

    protected $transformer;

    public function __construct(GlobalMeasurementTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Transform Measurement into api readable array
     * @param  Measurement $measurement
     * @return array
     * tested
     */
    public function transform(Measurement $measurement)
    {
        return [
            'id' => $measurement->id,
            'global_measurement' => $this->transformer->transform($measurement->globalMeasurement),
        ];
    }

}
