<?php

namespace App\PRS\ValueObjects\Report;

use App\PRS\ValueObjects\Administrator\TagTurbidity;

class Turbidity extends BaseReading{

    protected $classes = [ 1 => 'success', 2 => 'primary',
                        3 => 'warning', 4 => 'danger'];

    public function __construct(int $reading, TagTurbidity $tag)
    {
        $this->reading = $reading;
        $this->tag = $tag;
    }

}
