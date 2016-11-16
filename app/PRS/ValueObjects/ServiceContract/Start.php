<?php

namespace App\PRS\ValueObjects\ServiceContract;

use Carbon\Carbon;

class Start{

    protected $start;

    public function __construct(string $start)
    {
        $this->start = $start;
    }

    public function datePickerValue()
    {
        return (new Carbon($this->start))->toIso8601String();
    }

    /**
     * Convert to string
     * @return string
     */
    public function __toString()
    {
        return (new Carbon($this->start))->format('d M Y');
    }

}
