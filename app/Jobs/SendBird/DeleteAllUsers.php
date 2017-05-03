<?php

namespace App\Jobs\SendBird;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\PRS\Classes\SendBird;

class DeleteAllUsers //implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $maxLoopIterations = 10;
        $i = 0;
        $urcs = SendBird::getAll()->users;
        while (count($urcs) > 0) {
            foreach($urcs as $urc){
                SendBird::delete($urc->user_id);
            }
            $urcs = SendBird::getAll()->users;
            if ($i++ > $maxLoopIterations) {
                echo "too many iterations...";
                break;
            }
        }
    }
}
