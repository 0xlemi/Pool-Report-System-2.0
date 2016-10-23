<?php

namespace App\PRS\Classes\ValueObjects\Service;

use App\Service;

class Status{

    protected $status;

    public function __construct(bool $status)
    {
        $this->status = $status;
    }

    /**
     * Get span html tag with in pill form or square
     * @param  boolean $pill  adds class 'label-pill' to the span
     * @return string
     * tested
     */
    public function styled($pill = false)
    {
        $tag_type = '';
    	if($pill){
    		$tag_type = 'label-pill';
    	}
        $class = ($this->status) ? 'success':'danger';
    	return "<span class=\"label {$tag_type} label-{$class}\">{$this}</span>";
    }

    /**
     * @return string
     * tested
     */
    public function __toString()
    {
        return ($this->status) ? 'Active':'Inactive';
    }

}
