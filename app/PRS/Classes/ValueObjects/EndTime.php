<?php

namespace App\PRS\Classes\ValueObjects;

use Carbon\Carbon;
use App\PRS\Helpers\ReportHelpers;
use App\Service;

class EndTime{

    protected $reportHelpers;
    protected $service;
    protected $timezone;

    public function __construct(Service $service, ReportHelpers $reportHelpers)
    {
        $this->reportHelpers = $reportHelpers;
        $this->service = $service;
        $this->timezone = $this->service->admin()->timezone;
    }

    public function colored()
    {
        $isLate = $this->reportHelpers->checkIsLate(
                            Carbon::now($this->timezone),
                            $this->service->end_time,
                            $this->timezone
                        );
        $class = ($isLate) ? 'danger':'success';
        return "<span class=\"label label-{$class}\">{$this}</span>";
    }


    public function __toString()
    {
        return (new Carbon($this->service->end_time))->format('g:i:s A');;
    }

}
