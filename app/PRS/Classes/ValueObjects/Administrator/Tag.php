<?php

namespace App\PRS\Classes\ValueObjects\Administrator;


class Tag{

    protected $veryLow;
    protected $low;
    protected $perfect;
    protected $high;
    protected $veryHigh;

    public function __construct($veryLow, $low, $perfect,
                                $high, $veryHigh)
    {
        $this->veryLow = $veryLow;
        $this->low = $low;
        $this->perfect = $perfect;
        $this->high = $high;
        $this->veryHigh = $veryHigh;
    }

    /**
     * Get tag depending on reading
     * @param  int    $num  value reading
     * @return string       tag
     * tested
     */
    public function fromReading(int $num)
    {
        return $this->asArray()[$num];
    }

    /**
     * Array with tag names
     * @return array
     * tested
     */
    public function asArray()
    {
        return [
                1 => $this->veryLow,
                2 => $this->low,
                3 => $this->perfect,
                4 => $this->high,
                5 => $this->veryHigh,
            ];
    }

}
