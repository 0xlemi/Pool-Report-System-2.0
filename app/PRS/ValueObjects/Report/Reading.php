<?php

namespace App\PRS\ValueObjects\Report;

use App\PRS\ValueObjects\Administrator\Tag;

class Reading extends BaseReading{

    protected $classes = [ 1 =>'info', 2 => 'primary',
                        3 => 'success', 4 => 'warning',
                        5 => 'danger'];

    public function __construct(int $reading, Tag $tag)
    {
        $this->reading = $reading;
        $this->tag = $tag;
    }

}
