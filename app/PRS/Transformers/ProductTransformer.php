<?php

namespace App\PRS\Transformers;

use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\GlobalProductTransformer;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\Product;


/**
 * Transformer for the report class
 */
class ProductTransformer extends Transformer
{
    protected $imageTransformer;
    protected $globalProductTransformer;
    protected $serviceTransformer;

    public function __construct(ImageTransformer $imageTransformer,
                        GlobalProductTransformer $globalProductTransformer,
                        ServicePreviewTransformer $serviceTransformer)
    {
        $this->imageTransformer = $imageTransformer;
        $this->globalProductTransformer = $globalProductTransformer;
        $this->serviceTransformer = $serviceTransformer;
    }

    /**
     * Transform App\Product to api friendly array
     * @param  Product $product
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id' => $product->id,
            'amount' => $product->amount,
            'service' => $this->serviceTransformer->transform($product->service),
            'global_product' => $this->globalProductTransformer->transform($product->globalProduct),
        ];
    }

}
