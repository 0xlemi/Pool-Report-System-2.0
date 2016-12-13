<?php

namespace App\PRS\Helpers;

use Illuminate\Support\Collection;

/**
 * Helpers for technician elements
 */
class TechnicianHelpers
{

    /**
     * Transform collection of technician to generate dropdown options
     * @param  Collection $technician
     * @return Collection
     */
    public function transformForDropdown(Collection $technician)
    {
        return $technician
                ->transform(function($item){
                    return (object) array(
                        'key' => $item->seq_id,
                        'label' => $item->name.' '.$item->last_name,
                        'icon' => \Storage::url($item->icon()),
                    );
                });
    }

    public function styleStatus(int $active)
    {
        if($active){
            return '<h3><span class="label label-success">Active</span></h3>';
        }
        return '<h3><span class="label label-danger">Inactive</span></h3>';
    }

}
