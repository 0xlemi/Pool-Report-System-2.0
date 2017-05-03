<?php

namespace App\PRS\Transformers;
use App\Measurement;


/**
 * Transformer for the Measurement class
 */
class MeasurementTransformer extends Transformer
{

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
            'name' => $measurement->name,
            'amount' => $measurement->amount,
            'units' => $measurement->units,
        ];
    }

}
