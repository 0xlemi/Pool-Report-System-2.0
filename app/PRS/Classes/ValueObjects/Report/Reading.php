<?php

namespace App\PRS\Classes\ValueObjects\Report;

use App\PRS\Classes\ValueObjects\Administrator\Tag;

class Reading{

    protected $reading;
    protected $tag;
    protected $classes = [ 1 =>'info', 2 => 'primary',
                        3 => 'success', 4 => 'warning',
                        5 => 'danger'];

    public function __construct(int $reading, Tag $tag)
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
