<?php

namespace App\PRS\Transformers;

use App\Technician;
use App\Supervisor;

use App\PRS\Transformers\SupervisorTransformer;
use App\PRS\Transformers\ImageTransformer;

use Auth;

/**
 * Transformer for the technician class
 */
class TechnicianTransformer extends Transformer
{

    private $supervisorTransformer;
    private $imageTransformer;

    public function __construct(
                    SupervisorTransformer $supervisorTransformer,
                    ImageTransformer $imageTransformer)
    {
        $this->supervisorTransformer = $supervisorTransformer;
        $this->imageTransformer = $imageTransformer;
    }


    public function transform(Technician $technician)
    {

        return [
            'id' => $technician->seq_id,
            'name' => $technician->name,
            'last_name' => $technician->last_name,
            'username' => $technician->user()->email,
            'cellphone' => $technician->cellphone,
            'address' => $technician->address,
            'language' => $technician->language,
            'getReportsEmails' => $technician->get_reports_emails,
            'comments' => $technician->comments,
            'photo' => $this->imageTransformer->transform($technician->image(1, false)),
            'supervisor' => $this->supervisorTransformer->transform($technician->supervisor()),
        ];
    }


}
