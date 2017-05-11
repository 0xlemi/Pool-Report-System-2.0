<?php

namespace App\PRS\Transformers;

use App\UserRoleCompany;
use App\Service;

use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\CompanyPreviewTransformer ;
use App\PRS\Transformers\RoleTransformer;
use App\PRS\Transformers\UserTransformer;
use App\PRS\Transformers\ImageTransformer;

use Auth;

/**
 * Transformer for the client class to api readible array
 */
class UserRoleCompanyTransformer extends Transformer
{

    private $servicePreviewTransformer;
    private $imageTransformer;
    private $roleTransformer;
    private $companyTransformer;
    private $userTransformer;

    public function __construct(ServicePreviewTransformer $servicePreviewTransformer,
                                ImageTransformer $imageTransformer,
                                RoleTransformer $roleTransformer,
                                CompanyPreviewTransformer $companyTransformer,
                                UserTransformer $userTransformer)
    {
        $this->servicePreviewTransformer = $servicePreviewTransformer;
        $this->imageTransformer = $imageTransformer;
        $this->roleTransformer = $roleTransformer;
        $this->companyTransformer = $companyTransformer;
        $this->userTransformer = $userTransformer;
    }

    /**
     * Transform UserRoleCompany to api readible array
     * @param  UserRoleCompany $urc
     * @return array
     * tested
     */
    public function transform(UserRoleCompany $urc)
    {
        $photo = 'no image';
        if($urc->imageExists()){
            $photo = $this->imageTransformer->transform($urc->image(1, false));
        }

        return collect([
            'id' => $urc->seq_id,
            'user' => $this->userTransformer->transform($urc->user),

            'cellphone' => $urc->cellphone,
            'address' => $urc->address,
            'about' => $urc->about,

            'selected' => $urc->selected,
            'accepted' => $urc->accepted,
            'paid' => $urc->paid,

    		'role' => $this->roleTransformer->transform($urc->role),
    		'company' => $this->companyTransformer->transform($urc->company),
            'photo' => $photo,
            // make this more readable
            // 'notification_settings' => [
            //     $urc->allNotificationSettings()
            // ],
        ])->when($urc->isRole('client'), function ($collection) use ($urc){
            return $collection->merge([
                'type' => ($urc->type == 1) ? 'Owner' : 'House Admin',
                'services' => $this->servicePreviewTransformer->transformCollection($urc->services)
            ]);
        });
    }


}
