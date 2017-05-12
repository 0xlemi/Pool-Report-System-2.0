<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\Supervisor;

use App\PRS\Transformers\Transformer;
use App\PRS\Transformers\ImageTransformer;
use App\UserRolecompany;

/**
 * Transformer for the service class
 */
class UserRoleCompanyPreviewTransformer extends Transformer
{

    private $imageTransformer;

    public function __construct(ImageTransformer $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
    }


    public function transform(UserRolecompany $urc)
    {
        $photo = 'no image';
        if($urc->imageExists()){
            $photo = $this->imageTransformer->transform($urc->image(1, false));
        }

        return collect([
            'id' => $urc->seq_id,
            'name' => $urc->user->name,
            'last_name' => $urc->user->last_name,
            'role' => $urc->role->name,
            'href' => url("api/v1/userrolecompanies/{$urc->seq_id}"),
            'photo' => $photo,
        ])->when($urc->isRole('client'), function ($collection) use ($urc){
            return $collection->merge([
                'type' => ($urc->type == 1) ? 'Owner' : 'House Admin',
            ]);
        });
    }


}
