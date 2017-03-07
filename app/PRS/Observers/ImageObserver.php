<?php

namespace App\PRS\Observers;

use App\Image;
use App\Jobs\DeleteImageFromS3;

class ImageObserver
{
    /**
     * Listen to the Image deleting event.
     *
     * @param  Image  $image
     * @return void
     */
    public function deleted(Image $image)
    {
        dispatch(new DeleteImageFromS3($image->big, $image->medium, $image->thumbnail, $image->icon));
    }
}
