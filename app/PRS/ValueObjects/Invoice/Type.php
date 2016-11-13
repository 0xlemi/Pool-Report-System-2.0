<?php

namespace App\PRS\ValueObjects\Invoice;

class Type{

    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    protected function color()
    {
        if($this->type == 'App\ServiceContract'){
            return 'primary';
        }elseif($this->type == 'App\WorkOrder'){
            return 'success';
        }else{
            return 'default';
        }

    }

    public function styled(bool $pill)
    {
        $tag_type = '';
    	if($pill){
    		$tag_type = 'label-pill';
    	}
        $class = $this->color();
    	return "<span class=\"label {$tag_type} label-{$class}\">{$this}</span>";
    }


    public function __toString()
    {
        // Put spaces between capital letters and remove 'App\'
        return ltrim(preg_replace('/[A-Z]/', ' $0', substr($this->type, 4)));
    }

}
