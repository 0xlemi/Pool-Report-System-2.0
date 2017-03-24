<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use App\Jobs\DeleteImageFromS3;

class DeleteImagesFromS3 implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $images;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $images)
    {
        $this->images = $images;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->images as $image) {
            // Delete the image files from s3 too
            dispatch(new DeleteImageFromS3($image->big, $image->medium, $image->thumbnail, $image->icon));
            $image->delete();
        }
    }
}
