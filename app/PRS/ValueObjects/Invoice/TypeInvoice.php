<?php

namespace App\PRS\ValueObjects\Invoice;

use App\PRS\ValueObjects\All\Type;

class TypeInvoice extends Type{

    protected function colorClass()
    {
        if($this->type == 'App\ServiceContract'){
            return 'primary';
        }elseif($this->type == 'App\WorkOrder'){
            return 'success';
        }else{
            return 'default';
        }
    }

    /**
     * Get styled span tag of the type
     * @param  boolean $pill
     * @return string
     * tested
     */
    public function styled($pill = false)
    {
        $tag_type = '';
    	if($pill){
    		$tag_type = 'label-pill';
    	}
        $class = $this->colorClass();
    	return "<span class=\"label {$tag_type} label-{$class}\">{$this}</span>";
    }

}
