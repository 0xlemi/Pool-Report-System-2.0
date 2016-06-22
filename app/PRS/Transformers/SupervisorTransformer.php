<?php

namespace App\PRS\Transformers;

use App\Supervisor;


/**
 * Transformer for the supervisor class
 */
class SupervisorTransformer extends Transformer
{


    public function transform(Supervisor $supervisor)
    {
        return [
            'id' => $supervisor->seq_id,
            'name' => $supervisor->name,
            'last_name' => $supervisor->last_name,
            'email' => $supervisor->user()->email,
            'cellphone' => $supervisor->cellphone,
            'address' => $supervisor->address,
            'language' => $supervisor->language,
            'comments' => $supervisor->comments,
        ];
    }


}
