<?php

namespace App\PRS\Transformers;

use App\Image;
use Storage;

/**
 * Transformer for the image class
 */
class ImageTransformer extends Transformer
{

    /**
     * Transform Image to api friendly array
     * @param  Image  $image
     * @return array
     * tested
     */
    public function transform(Image $image)
    {
        $name = title_case(str_replace('_', ' ', snake_case($image->imageable->modelName())));
        if($image->imageable->modelName() == 'report'){
            switch ($image->order) {
                case '1':
                    $name = "Main Pool";
                    break;
                case '2':
                    $name = "Water Quality";
                    break;
                case '3':
                    $name = "Engine Room";
                    break;
            }
        }
        $title = "{$name} Photo";

        if($image->processing){
            return [
                'processing' => $image->processing,
                'order' => $image->order,
                'title' => $title ,
            ];
        }
        return [
            'big' => Storage::url($image->big),
            'medium' =>  Storage::url($image->medium),
            'thumbnail' =>  Storage::url($image->thumbnail),
            'icon' =>  Storage::url($image->icon),
            'order' => $image->order,
            'title' => $title ,
        ];
    }

}
