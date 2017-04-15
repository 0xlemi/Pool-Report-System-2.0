<?php

namespace App\PRS\Transformers;

use App\Technician;
use App\Supervisor;

use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\PreviewTransformers\SupervisorPreviewTransformer;

use Auth;

/**
 * Transformer for the technician class
 */
class TechnicianTransformer extends Transformer
{

    private $supervisorPreviewTransformer;
    private $imageTransformer;

    public function __construct(
                    SupervisorPreviewTransformer $supervisorPreviewTransformer,
                    ImageTransformer $imageTransformer)
    {
        $this->supervisorPreviewTransformer = $supervisorPreviewTransformer;
        $this->imageTransformer = $imageTransformer;
    }


    /**
     * Transform Technician to api friendly array
     * @param  Technician $technician
     * @return array
     * tested
     */
    public function transform(Technician $technician)
    {

        $photo = 'no image';
        if($technician->imageExists()){
            $photo = $this->imageTransformer->transform($technician->image(1, false));
        }

        return [
            'id' => $technician->seq_id,
            'name' => $technician->name,
            'last_name' => $technician->last_name,
            'username' => $technician->user->email,
            'cellphone' => $technician->cellphone,
            'address' => $technician->address,
            'language' => $technician->language,
            'active' => $technician->user->active,
            'comments' => $technician->comments,
            'photo' => $photo,
            'supervisor' => $this->supervisorPreviewTransformer->transform($technician->supervisor),
            'notification_settings' => [
                $technician->user->selectedUser->allNotificationSettings()
            ],
        ];
    }


}
