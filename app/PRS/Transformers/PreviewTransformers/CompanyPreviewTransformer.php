<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\Company;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\Transformer;


/**
 * Transformer for the company class
 */
class CompanyPreviewTransformer extends Transformer
{
    protected $imageTransformer;

    /**
     * Transform Company to api friendly array
     * @param  Company $company
     * @return array
     */
    public function transform(Company $company)
    {
        return [
            'name' => $company->name,
            'href' => url("api/v1/company"),
        ];
    }

}
