<?php

namespace App\PRS\Transformers\FrontEnd;


use App\PRS\Transformers\Transformer;
use App\Reading;


/**
 * Transformer for the report class
 */
class ReadingFrontTransformer extends Transformer
{

    public function __construct()
    {
        //
    }

    /**
     * Transform Report to api friendly array
     * @param  Reading $reading
     * @return array
     */
    public function transform(Reading $reading)
    {
        $globalMeasurement = $reading->globalMeasurement;
        $labels = $globalMeasurement->labels;
        $color = $globalMeasurement->labels()->whereValue($reading->value)->color;
        return [
            'title' => $globalMeasurement->name,
            'tags' => $labels->pluck('name')->toArray(),
            'value' => $reading->value,
            'color' => [
                'red' =>  hexdec(substr($color, 0, 2)),
                'green' =>  hexdec(substr($color, 2, 2)),
                'blue' =>  hexdec(substr($color, 4, 2)),
            ],
        ];
    }

}
