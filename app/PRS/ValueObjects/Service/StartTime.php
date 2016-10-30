<?php

namespace App\PRS\ValueObjects\Service;

use Carbon\Carbon;
use App\Service;

class StartTime{

    protected $startTime;

    public function __construct(string $startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * Get the start time in a format that timePicker accepts
     * @return string
     * tested
     */
    public function timePickerValue()
    {
        return (new Carbon($this->startTime))->format('H:i');
    }

    /**
     * Convert to string
     * @return string
     * tested
     */
    public function __toString()
    {
        return (new Carbon($this->startTime))->format('g:i:s A');
    }

}
