<?php

namespace App\PRS\Helpers;

use App\PRS\Traits\HelperTrait;
use App\UserRoleCompany;
use Illuminate\Database\Eloquent\Collection;

/**
 * Helpers for client elements
 */
class UserRoleCompanyHelpers
{

use HelperTrait;

    /**
     * Transform collection of supervisors to generate dropdown options
     * @param  Collection $userRoleCompanies
     * @return Collection
     */
    public function transformForDropdown(Collection $userRoleCompanies)
    {
        return $userRoleCompanies
                ->transform(function($item){
                    return (object) array(
                        'key' => $item->seq_id,
                        'label' => $item->user->fullName.' - '.$item->role->text,
                        'icon' => \Storage::url($item->user->icon()),
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

    function styledTypeClient($type, $is_pill = true, $long_version = true){
    	$tag_type = '';
    	$extra_text = '';
    	if($is_pill){
    		$tag_type = 'label-pill';
    	}if($long_version){
    		$extra_text = 'House ';
    	}
    	switch ($type) {
    		case 1:
    			return '<span class="label '.$tag_type.' label-primary">'.$extra_text.'Owner</span>';
    			break;
    		case 2:
    			return '<span class="label '.$tag_type.' label-warning">'.$extra_text.'Administrator</span>';
    			break;
    		default:
    			return '<span class="label '.$tag_type.' label-default">Unknown</span>';
    			break;
    	}
    }

}
