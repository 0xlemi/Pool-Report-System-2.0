<?php

namespace App\PRS\Transformers;

use App\Image;

/**
 * Transformer for the image class
 */
class ImageTransformer extends Transformer
{

    public function transform(Image $image)
    {
        return [
            'full_size' => url($image->normal_path),
            'thumbnail' => url($image->thumbnail_path),
            'icon' => url($image->icon_path),            
        ];
    }

}
