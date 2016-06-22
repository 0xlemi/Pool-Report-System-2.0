<?php

namespace App\PRS\Transformers;

use App\Technician;


/**
 * Transformer for the technician class
 */
class TechnicianTransformer extends Transformer
{


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
        ];
    }


}
