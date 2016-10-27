<?php

namespace App\PRS\ValueObjects\Administrator;


class TagTurbidity extends BaseTag{

    protected $perfect;
    protected $low;
    protected $high;
    protected $veryHigh;

    protected $colors = [ 4 => '#FA424A',
                        3 => '#FDAD2A',
                        2 => '#00A8FF',
                        1 => '#46C35F'];

    public function __construct($perfect, $low,
                                $high, $veryHigh)
    {
        $this->perfect = $perfect;
        $this->low = $low;
        $this->high = $high;
        $this->veryHigh = $veryHigh;
    }

    /**
     * Array with tag names
     * @return array
     * tested
     */
    public function asArray()
    {
        return [
                4 => $this->veryHigh,
                3 => $this->high,
                2 => $this->low,
                1 => $this->perfect,
            ];
    }

}
