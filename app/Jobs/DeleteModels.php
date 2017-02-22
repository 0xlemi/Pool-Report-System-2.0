<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;

class DeleteModels implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $models;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $models)
    {
        $this->models = $models;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->models as $model) {
            $model->delete();
        }
    }
}
