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

    /**
     * Get the carbon date in the corresponding timezone
     * @return Carbor\Carbon
     * tested
     */
    public function carbon()
    {
        return (new Carbon($this->date, 'UTC'))->setTimezone($this->timezone);
    }

    /**
     * Get a long representation of the date
     * @return string
     * tested
     */
    public function long()
    {
        return $this->carbon()->format('l jS \\of F Y h:i:s A');
    }

    /**
     * Check if the Work Order is finished or not
     * @return boolean
     * tested
     */
    public function finished()
    {
        return ($this->date != null);
    }

    /**
     * @return string
     * tested
     */
    public function __toString()
    {
        if(!$this->finished()){
            return "Not Finished";
        }
        return $this->carbon()->format('d M Y h:i:s A');
    }

}
