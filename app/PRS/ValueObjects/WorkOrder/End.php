<?php

namespace App\PRS\ValueObjects\WorkOrder;
use Carbon\Carbon;


class End{

    protected $date;
    protected $timezone;

    public function __construct($date, $timezone)
    {
        $this->date = $date;
        $this->timezone = $timezone;
    }

    public function carbon()
    {
        return (new Carbon($this->date, 'UTC'))->setTimezone($this->timezone);
    }

    public function long()
    {
        return $this->carbon()->format('l jS \\of F Y h:i:s A');
    }

    public function finished()
    {
        return ($this->date != null);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(!$this->finished()){
            return "Not Finished";
        }
        return $this->carbon()->format('d M Y h:i:s A');
    }

}
