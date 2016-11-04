<?php

namespace App\PRS\Transformers;

use App\Image;

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
        return [
            'full_size' => url($image->normal_path),
            'thumbnail' => url($image->thumbnail_path),
            'icon' => url($image->icon_path),
            'order' => $image->order,
            'title' => 'Photo title',
        ];
    }

}
