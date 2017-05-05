<?php

namespace App\PRS\Transformers\FrontEnd;

use App\GlobalProduct;

use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\Transformer;


/**
 * Transformer for the report class
 */
class GlobalProductFrontTransformer extends Transformer
{
    protected $imageTransformer;

    public function __construct(ImageTransformer $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * Transform GlobalProduct to api friendly array
     * @param  GlobalProduct $globalProduct
     * @return array
     */
    public function transform(GlobalProduct $globalProduct)
    {
        return [
            'id' => $globalProduct->seq_id,
            'name'=> $globalProduct->name,
            'brand'=> $globalProduct->brand,
            'type'=> $globalProduct->type,
            'units'=> $globalProduct->units,
            'unit_price'=> $globalProduct->unit_price,
            'unit_currency'=> $globalProduct->unit_currency,
            'price' => $globalProduct->unit_price.' '.$globalProduct->unit_currency.' per '.str_singular($globalProduct->units),
            'photos' => $this->imageTransformer->transformCollection($globalProduct->images),
        ];
    }


}
