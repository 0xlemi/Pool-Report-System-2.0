<?php

namespace App\PRS\Transformers;

use App\Label;
use App\PRS\Transformers\ImageTransformer;


/**
 * Transformer for the report class
 */
class LabelTransformer extends Transformer
{
    protected $imageTransformer;

    /**
     * Transform Label to api friendly array
     * @param  Label $label
     * @return array
     */
    public function transform(Label $label)
    {
        return [
            'id' => $label->id,
            'name' => $label->name,
            'color'=> $label->color,
            'value'=> $label->value,
        ];
    }


}
