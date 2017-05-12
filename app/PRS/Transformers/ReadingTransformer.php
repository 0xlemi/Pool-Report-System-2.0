<?php

namespace App\PRS\Transformers;
use App\Reading;
use App\PRS\Transformers\LabelTransformer;


/**
 * Transformer for the Reading class
 */
class ReadingTransformer extends Transformer
{

    protected $labelTrasformer;

    public function __construct(LabelTransformer $labelTrasformer)
    {
        $this->labelTrasformer = $labelTrasformer;
    }

    /**
     * Transform Reading into api readable array
     * @param  Reading $reading
     * @return array
     * tested
     */
    public function transform(Reading $reading)
    {
        $globalMeasurement = $reading->measurement->globalMeasurement;
        return [
            'name' => $globalMeasurement->name,
            'label' => $this->labelTrasformer->transform($globalMeasurement->labels()->whereValue($reading->value)),
        ];
    }

}
