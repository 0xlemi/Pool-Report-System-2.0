<?php

namespace App\PRS\Transformers\FrontEnd\DataTables;

use App\PRS\Transformers\Transformer;
use App\Equipment;

/**
 * Transformer for the equipment class
 */
class EquipmentDatatableTransformer extends Transformer
{

    /**
     * Transform Equipment to friendly array
     * @param  Equipment $equipment
     * @return array
     */
    public function transform(Equipment $equipment)
    {
        return [
            'id' => $equipment->id,
            'kind' => '<strong>'.$equipment->kind.'</strong>',
            'type' => $equipment->type,
            'brand' => $equipment->brand,
            'model' => $equipment->model,
            'capacity' => $equipment->capacity.' '.$equipment->units,
        ];
    }

}
