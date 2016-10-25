<?php

namespace App\PRS\ValueObjects\Report;
use App\PRS\ValueObjects\Administrator\BaseTag;

abstract class BaseReading{

    protected $reading;
    protected $tag;

    public function __construct(int $reading, BaseTag $tag)
    {
        $this->reading = $reading;
        $this->tag = $tag;
    }

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
