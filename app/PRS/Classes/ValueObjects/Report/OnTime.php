<?php

namespace App\PRS\Classes\ValueObjects\Report;

use App\Report;

class OnTime{

    protected $onTime;

    public function __construct($onTime)
    {
        $this->onTime = $onTime;
    }

    /**
     * Get html span with the styled
     * @return string
     * tested
     */
    public function styled()
    {
        $label = 'default';
        switch ($this->onTime) {
    		case 'early':
                $label = 'warning';
    			break;
    		case 'onTime':
                $label = 'success';
    			break;
    		case 'late':
                $label = 'danger';
    			break;
        }
        return "<span class=\"label label-{$label}\">{$this}</span>";
    }

    /**
     * @return string
     * tested
     */
    public function __toString()
    {
        switch ($this->onTime) {
    		case 'early':
    			return 'Early';
    			break;
    		case 'onTime':
    			return 'On Time';
    			break;
    		case 'late':
    			return 'Late';
    			break;
    		default:
    			return 'Unknown';
    			break;
    	}
    }

}
