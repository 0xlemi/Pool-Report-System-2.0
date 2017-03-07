<?php

namespace App\PRS\Transformers\FrontEnd\DataTables;

use App\PRS\Transformers\Transformer;
use App\PRS\Helpers\ClientHelpers;
use App\Supervisor;


/**
 * Transformer for the supervisor class
 */
class SupervisorDatatableTransformer extends Transformer
{

    /**
     * Transform supervisor for today's route to datatable friendly array
     * @param  supervisor $supervisor
     * @return array
     */
    public function transform(Supervisor $supervisor)
    {
        return [
            'id' => $supervisor->seq_id,
            'name' => $supervisor->name.' '.$supervisor->last_name,
            'email' => $supervisor->user->email,
            'cellphone' => $supervisor->cellphone,
        ];
    }

}
