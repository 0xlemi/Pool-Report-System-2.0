<?php

namespace App\PRS\Classes\ValueObjects;

use Carbon\Carbon;
use App\PRS\Helpers\ReportHelpers;

class EndTime{

    protected $reportHelpers;
    protected $end_time;

    public function __construct(ReportHelpers $reportHelpers, $end_time)
    {
        $this->reportHelpers = $reportHelpers;
        $this->end_time = $end_time;
    }


    public function colored()
    {
        $this->reportHelpers->checkOnTime();

    }


    public function __toString()
    {
        return (new Carbon($this->endtime))->format('g:i:s A');;
    }

}
