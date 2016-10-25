<?php

namespace App\PRS\Classes\ValueObjects\Report;

use App\PRS\Classes\ValueObjects\Administrator\Tag;

class Reading{

    protected $reading;
    protected $tag;

    public function __construct(int $reading, Tag $tag)
    {
        $this->reading = $reading;
        $this->tag = $tag;
    }

    public function __toString()
    {
        return $this->tag->fromReading($this->reading);
    }

}
