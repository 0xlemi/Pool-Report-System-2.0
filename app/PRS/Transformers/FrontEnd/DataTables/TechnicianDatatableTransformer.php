<?php

namespace App\PRS\Transformers\FrontEnd\DataTables;

use App\PRS\Transformers\Transformer;
use App\Technician;

/**
 * Transformer for the technician class
 */
class TechnicianDatatableTransformer extends Transformer
{

    /**
     * Transform technician for today's route to datatable friendly array
     * @param  technician $technician
     * @return array
     */
    public function transform(Technician $technician)
    {
        $supervisor = $technician->supervisor;
        return [
            'id' => $technician->seq_id,
            'name' => $technician->name.' '.$technician->last_name,
            'username' => $technician->user->email,
            'cellphone' => $technician->cellphone,
            'supervisor' => $supervisor->name.' '.$supervisor->last_name,
        ];
    }

}
