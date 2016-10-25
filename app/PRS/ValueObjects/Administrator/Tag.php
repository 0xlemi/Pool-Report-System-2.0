<?php

namespace App\PRS\ValueObjects\Administrator;


class Tag implements BaseTag{

    protected $veryLow;
    protected $low;
    protected $perfect;
    protected $high;
    protected $veryHigh;

    protected $colors = [ 5 => '#FA424A',
                        4 => '#FDAD2A',
                        3 => '#46C35F',
                        2 => '#00A8FF',
                        1 => '#AC6BEC'];

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

    public function asArrayWithColor()
    {
        $styled = [];
        foreach ($this->asArray() as $key => $value) {
            $styled[$key] = (object)[ 'text' => $value, 'color' => $this->colors[$key]];
        }
        return $styled;
    }

    /**
     * Array with tag names
     * @return array
     * tested
     */
    public function asArray()
    {
        return [
                5 => $this->veryHigh,
                4 => $this->high,
                3 => $this->perfect,
                2 => $this->low,
                1 => $this->veryLow,
            ];
    }

}
