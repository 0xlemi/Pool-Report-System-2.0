<?php

namespace App\PRS\Transformers;

use App\Company;
use App\PRS\Transformers\ImageTransformer;


/**
 * Transformer for the company class
 */
class CompanyTransformer extends Transformer
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
            'timezone' => $company->timezone,
            'language' => $company->language,
            'location' => [
                'latitude' => $company->latitude,
                'longitude' => $company->longitude,
            ],
            'website' => $company->website,
            'facebook' => $company->facebook,
            'twitter' => $company->twitter,
        ];
    }
}
