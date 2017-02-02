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

    protected $image;
    protected $storageFolder;
    protected $randomName;
    protected $tempFilePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Image $image, string $storageFolder, string $randomName, string $tempFilePath)
    {
        $this->image = $image;
        $this->storageFolder = $storageFolder;
        $this->randomName = $randomName;
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

        // Store final Images in S3
        Storage::put("{$this->storageFolder}/bg_{$this->randomName}.jpg", $streamBig, 'public');
        Storage::put("{$this->storageFolder}/md_{$this->randomName}.jpg", $streamMedium, 'public');
        Storage::put("{$this->storageFolder}/sm_{$this->randomName}.jpg", $streamThumbnail, 'public');
        Storage::put("{$this->storageFolder}/ic_{$this->randomName}.jpg", $streamIcon, 'public');

        // Finaly delete temp file
        Storage::delete($this->tempFilePath);

        // Set image paths in database
        $this->image->processing = 0;
        $this->image->save();
    }
}
