<?php

namespace App\PRS\Helpers;

use Carbon\Carbon;
use App\PRS\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Collection;

class GlobalProductHelpers
{

    use HelperTrait;

    /**
     * Transform collection of supervisors to generate dropdown options
     * @param  Collection $globalProducts
     * @return Collection
     */
    public function transformForDropdown(Collection $globalProducts)
    {
        return $globalProducts
                ->transform(function($item){
                    return (object) array(
                        'key' => $item->seq_id,
                        'label' => "{$item->seq_id} {$item->name} - {$item->brand} - {$item->type}",
                        'icon' => \Storage::url($item->icon()),
                    );
                });
    }


}
