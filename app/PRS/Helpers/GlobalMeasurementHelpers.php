<?php

namespace App\PRS\Helpers;

use Carbon\Carbon;
use App\PRS\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Collection;

class GlobalMeasurementHelpers
{

    use HelperTrait;

    /**
     * Transform collection of supervisors to generate dropdown options
     * @param  Collection $globalMeasurements
     * @return Collection
     */
    public function transformForDropdown(Collection $globalMeasurements)
    {
        return $globalMeasurements
                ->transform(function($item){
                    return (object) array(
                        'key' => $item->seq_id,
                        'label' => "{$item->seq_id} {$item->name}",
                        'icon' => \Storage::url($item->icon()),
                    );
                });
    }


}
