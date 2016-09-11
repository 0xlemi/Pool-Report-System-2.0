<?php

namespace App\PRS\Transformers;

use App\PRS\Transformers\ImageTransformer;

use Auth;
use App\Technician;
use App\Work;

/**
 * Transformer for the technician class
 */
class WorkTransformer extends Transformer
{

    private $imageTransformer;

    public function __construct(ImageTransformer $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
    }


    public function transform(Work $work)
    {
        try{
            $technicianObject = Technician::findOrFail($work->technician_id);

            $technicianPhoto = [];
            if($technicianObject->imageExists()){
                $technicianPhoto = $this->imageTransformer->transform($technicianObject->image(1, false));
            }
            $technician = [
                'id' => $technicianObject->seq_id,
                'name' => $technicianObject->name,
                'last_name' => $technicianObject->last_name,
                'photo' => $technicianPhoto,
            ];
        }catch(ModelNotFoundException $e){
            $technician = 'No Technician';
        }

        $photos = [];
        if($work->numImages() > 0){
            $photos = $this->imageTransformer->transformCollection($work->images()->get());
        }

        return [
            'id' => $work->id,
            'title' => $work->title,
            'description' => $work->description,
            'quantity' => $work->quantity,
            'units' => $work->units,
            'cost' => $work->cost,
            'technican' => $technician,
            'photos' => $photos,
        ];
    }
}
