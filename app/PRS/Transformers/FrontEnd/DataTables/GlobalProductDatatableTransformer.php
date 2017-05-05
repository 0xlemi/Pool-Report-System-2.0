<?php

namespace App\PRS\Transformers\FrontEnd\DataTables;

use App\GlobalProduct;
use App\PRS\Transformers\Transformer;

/**
 * Transformer for the GlobalProduct class
 */
class GlobalProductDatatableTransformer extends Transformer
{

    /**
     * Transform GlobalProduct into api readable array
     * @param  GlobalProduct $globalProduct
     * @return array
     * tested
     */
    public function transform(GlobalProduct $globalProduct)
    {
        return [
            'id' => $globalProduct->seq_id,
            'name' => $globalProduct->name,
            'brand' => $globalProduct->brand,
            'type' => $globalProduct->type,
            'price' => $globalProduct->unit_price.' '.$globalProduct->unit_currency.' per '.str_singular($globalProduct->units),
        ];
    }

}
