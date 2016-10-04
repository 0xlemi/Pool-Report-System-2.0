<?php

namespace App\PRS\Transformers;

use App\Equipment;

use App\PRS\Transformers\ImageTransformer;

use Auth;

/**
 * Transformer for the technician class
 */
class EquipmentTransformer extends Transformer
{

    private $imageTransformer;

    public function __construct(ImageTransformer $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
    }

    public function transform(Equipment $equipment)
    {
        return [
            'kind' => $equipment->kind,
            'type' => $equipment->type,
            'brand' => $equipment->brand,
            'model' => $equipment->model,
            'capacity' => $equipment->capacity,
            'units' => $equipment->units,
            'photos' => $this->imageTransformer->transformCollection($equipment->images()->get()),
        ];
    }

}
