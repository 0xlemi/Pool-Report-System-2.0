<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

class DeleteImage implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $big;
    protected $medium;
    protected $thumbnail;
    protected $icon;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $big, string $medium, string $thumbnail, string $icon)
    {
        $this->big = $big;
        $this->medium = $medium;
        $this->thumbnail = $thumbnail;
        $this->icon = $icon;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // avoid removing the migrations photos
        if(!str_contains($this->big, 'migrations')){
            Storage::delete([
                $this->big,
                $this->medium,
                $this->thumbnail,
                $this->icon,
            ]);
        }
    }
}
