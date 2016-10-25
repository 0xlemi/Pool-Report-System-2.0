<?php

namespace App\PRS\ValueObjects\Administrator;


class TagTurbidity implements BaseTag{

    protected $perfect;
    protected $low;
    protected $high;
    protected $veryHigh;

    public function __construct($perfect, $low,
                                $high, $veryHigh)
    {
        $this->perfect = $perfect;
        $this->low = $low;
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
                1 => $this->perfect,
                2 => $this->low,
                3 => $this->high,
                4 => $this->veryHigh,
            ];
    }

}
