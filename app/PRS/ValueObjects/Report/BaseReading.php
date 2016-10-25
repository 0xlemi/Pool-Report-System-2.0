<?php

namespace App\PRS\ValueObjects\Report;

abstract class BaseReading{

    protected $reading;
    protected $tag;

    /**
     * Get the class color for depending on the reading
     * @return string      class name
     * tested
     */
    public function class()
    {
        return $this->classes[$this->reading];
    }

    /**
     * Get styled html span
     * @return string
     * tested
     */
    public function styled()
    {
		return "<span class=\"label label-{$this->class()}\">{$this}</span>";
    }

    /**
     * @return string
     * tested
     */
    public function __toString()
    {
        return $this->tag->fromReading($this->reading);
    }

}
