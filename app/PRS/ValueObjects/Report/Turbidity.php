<?php

namespace App\PRS\ValueObjects\Report;

class Turbidity extends BaseReading{

    protected $classes = [ 1 => 'success', 2 => 'primary',
                        3 => 'warning', 4 => 'danger'];

}
