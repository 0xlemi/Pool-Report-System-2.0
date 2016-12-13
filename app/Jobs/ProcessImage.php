<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use App\Image;
use Storage;
use Intervention;

class ProcessImage implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $object;
    protected $image;
    protected $tempFilePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Model $object, Image $image, string $tempFilePath)
    {
        $this->object = $object;
        $this->image = $image;
        $this->tempFilePath = $tempFilePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get the contents back from S3 temp
        $contents = Storage::get($this->tempFilePath);

        // Process image to get different sizes
        $img = Intervention::make($contents);
        // big
        $streamBig = (string) $img->fit(1200, null, function ($constraint) {
                $constraint->upsize();
            })->stream('jpg');
        // medium
        $streamMedium = (string) $img->fit(600, null, function ($constraint) {
                $constraint->upsize();
            })->stream('jpg');
        // thumbnail
        $streamThumbnail = (string) $img->fit(250, null, function ($constraint) {
                $constraint->upsize();
            })->stream('jpg');
        // icon
        $streamIcon = (string) $img->fit(64, null, function ($constraint) {
                $constraint->upsize();
            })->stream('jpg');

        $storageFolder = 'images/'.strtolower(substr(get_class($this->object), 4));

        //generate image names
        $randomName = str_random(50);
        // Store final Images in S3
        Storage::put("{$storageFolder}/bg_{$randomName}.jpg", $streamBig, 'public');
        Storage::put("{$storageFolder}/md_{$randomName}.jpg", $streamMedium, 'public');
        Storage::put("{$storageFolder}/sm_{$randomName}.jpg", $streamThumbnail, 'public');
        Storage::put("{$storageFolder}/ic_{$randomName}.jpg", $streamIcon, 'public');

        // Finaly delete temp file
        Storage::delete($this->tempFilePath);

        // Set image paths in database
        $this->image->big = "{$storageFolder}/bg_{$randomName}.jpg";
        $this->image->medium = "{$storageFolder}/md_{$randomName}.jpg";
        $this->image->thumbnail = "{$storageFolder}/sm_{$randomName}.jpg";
        $this->image->icon = "{$storageFolder}/ic_{$randomName}.jpg";
        $this->image->processing = 0;
        $this->image->save();
    }
}
