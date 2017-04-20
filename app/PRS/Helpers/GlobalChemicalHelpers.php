<?php

namespace App\PRS\Helpers;

use Carbon\Carbon;
use App\PRS\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Collection;

class GlobalChemicalHelpers
{

    use HelperTrait;

    /**
     * Transform collection of supervisors to generate dropdown options
     * @param  Collection $globalChemicals
     * @return Collection
     */
    public function transformForDropdown(Collection $globalChemicals)
    {
        return $globalChemicals
                ->transform(function($item){
                    return (object) array(
                        'key' => $item->seq_id,
                        'label' => $item->name,
                        'icon' => \Storage::url($item->icon()),
                    );
                });
    }


}
