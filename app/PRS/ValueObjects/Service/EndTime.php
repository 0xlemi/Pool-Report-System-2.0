<?php

namespace App\PRS\ValueObjects\Service;

use Carbon\Carbon;
use App\PRS\Helpers\ReportHelpers;
use App\Service;

class EndTime{

    protected $endTime;
    protected $timezone;
    protected $reportHelpers;

    public function __construct(string $endTime, string $timezone, ReportHelpers $reportHelpers)
    {
        $this->endTime = $endTime;
        $this->timezone = $timezone;
        $this->reportHelpers = $reportHelpers;
    }

    /**
     * Span tag with the end time in red if is late or green if is still on time
     * @return string  html span with time
     * tested
     */
    public function colored()
    {
        $isLate = $this->reportHelpers->checkIsLate(
                            Carbon::now($this->timezone),
                            $this->endTime,
                            $this->timezone
                        );
        $class = ($isLate) ? 'danger':'success';
        return "<span class=\"label label-{$class}\">{$this}</span>";
    }


    /**
     * Convert to string
     * @return string
     * tested
     */
    public function __toString()
    {
        return (new Carbon($this->endTime))->format('g:i:s A');
    }

}
