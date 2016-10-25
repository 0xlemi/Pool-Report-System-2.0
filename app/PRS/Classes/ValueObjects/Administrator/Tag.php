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

    public function fromNumber(int $num)
    {
        switch ($num) {
            case '1':
                return $this->veryLow;
                break;
            case '2':
                return $this->low;
                break;
            case '3':
                return $this->perfect;
                break;
            case '4':
                return $this->high;
                break;
            case '5':
                return $this->veryHigh;
                break;
            default:
                return 'Unknown';
                break;
        }
    }

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
