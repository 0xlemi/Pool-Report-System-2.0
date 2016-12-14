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
        $title = "Photo";
        if($image->processing){
            return [
                'processing' => $image->processing,
                'order' => $image->order,
                'title' => 'Photo title',
            ];
        }
        return [
            'big' => Storage::url($image->big),
            'medium' =>  Storage::url($image->medium),
            'thumbnail' =>  Storage::url($image->thumbnail),
            'icon' =>  Storage::url($image->icon),
            'order' => $image->order,
            'title' => 'Photo title',
        ];
    }

}
