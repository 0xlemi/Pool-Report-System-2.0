<?php

namespace App\PRS\Classes\ValueObjects\Administrator;


class TagTurbidity{

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

    public function fromReading(int $num)
    {
        switch ($num) {
            case '1':
                return $this->perfect;
                break;
            case '2':
                return $this->low;
                break;
            case '3':
                return $this->high;
                break;
            case '4':
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
                1 => $this->perfect,
                2 => $this->low,
                3 => $this->high,
                4 => $this->veryHigh,
            ];
    }

}
