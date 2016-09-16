<?php

namespace App\PRS\Helpers;
use Illuminate\Support\Collection;
use App\PRS\Traits\ControllerTrait;
use App\PRS\Traits\HelperTrait;

/**
 * Helpers for work order elements
 */
class WorkOrderHelpers
{
    use ControllerTrait;
    use HelperTrait;

    public function styleFinishedStatus(int $finished)
    {
        if($finished){
            return '<h3><span class="label label-success">Finished</span></h3>';
        }
        return '<h3><span class="label label-warning">Still on Progress</span></h3>';
    }
}
