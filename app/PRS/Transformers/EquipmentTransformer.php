<?php

namespace App\PRS\Transformers;

use App\Equipment;

use App\PRS\Transformers\ImageTransformer;

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

    /**
     * Transform Equimpent into api readable array
     * @param  Equipment $equipment
     * @return array
     * tested
     */
    public function transform(Equipment $equipment)
    {
        return [
            'id' => $equipment->id,
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
