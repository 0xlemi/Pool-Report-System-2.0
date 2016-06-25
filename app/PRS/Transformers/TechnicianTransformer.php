<?php

namespace App\PRS\Transformers;

use App\Technician;
use App\Supervisor;

use App\PRS\Transformers\SupervisorTransformer;

use Auth;

/**
 * Transformer for the technician class
 */
class TechnicianTransformer extends Transformer
{

    private $supervisorTransformer;

    public function __construct(SupervisorTransformer $supervisorTransformer)
    {
        $this->supervisorTransformer = $supervisorTransformer;
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
            'comments' => $technician->comments,
            'supervisor' => $this->supervisorTransformer->transform($technician->supervisor()),
        ];
    }


}
