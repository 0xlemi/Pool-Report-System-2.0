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
            'full_size' => $image->normal_path,
            'thumbnail' => $image->thumbnail_path,
            'icon' => $image->icon_path,            
        ];
    }

}
