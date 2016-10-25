<?php

namespace App\PRS\ValueObjects\Report;

class Reading extends BaseReading{

    protected $classes = [ 1 =>'info', 2 => 'primary',
                        3 => 'success', 4 => 'warning',
                        5 => 'danger'];
}
