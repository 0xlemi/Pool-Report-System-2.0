<?php

namespace App\PRS\Helpers;

use Carbon\Carbon;
use App\PRS\Traits\ControllerTrait;
use App\PRS\Traits\HelperTrait;

class ReportHelpers
{
    use HelperTrait;


    /**
     * Check if the completed date is late.
     * Dates and times should be in the admin->timezone not UTC
     * @param  Carbon $completedDate   date the report was made
     * @param  string $endTime
     * @param  string $timeTimezone  $admin->timezone
     * @return boolean
     * tested
     */
    public function checkIsLate(Carbon $completedDate, string $endTime, string $timeTimezone)
    {
        $carbonEnd = $this->prepareTime($completedDate, $endTime, $timeTimezone);

        // $completedDate happend later than $carbon_end
        return $completedDate->gt($carbonEnd);
    }

    /**
     * Check if the completed date is early.
     * Dates and times should be in the admin->timezone not UTC
     * @param  Carbon $completedDate   date the report was made
     * @param  string $startTime
     * @param  string $timeTimezone  $admin->timezone
     * @return boolean
     * tested
     */
    public function checkIsEarly(Carbon $completedDate, string $startTime, string $timeTimezone)
    {
        $carbonStart = $this->prepareTime($completedDate, $startTime, $timeTimezone);

        // $completedDate happend before $carbon_end
        return $completedDate->lt($carbonStart);
    }

    /**
     * Check if the completed date is onTime.
     * Dates and times should be in the admin->timezone not UTC
     * @param  Carbon $completedDate   date the report was made
     * @param  string $startTime
     * @param  string $endTime
     * @param  string $timesTimezone  $admin->timezone
     * @return boolean
     * tested
     */
    public function checkIsOnTime(Carbon $completedDate, string $startTime, string $endTime, string $timesTimezone)
    {
        $carbonStart = $this->prepareTime($completedDate, $startTime, $timesTimezone);
        $carbonEnd = $this->prepareTime($completedDate, $endTime, $timesTimezone);

        return $completedDate->between($carbonStart, $carbonEnd);
    }

    /**
     * Check if the completed date is late, early or on time
     * Dates and times should be in the admin->timezone not UTC
     * @param  Carbon $completedDate   date the report was made
     * @param  string $startTime
     * @param  string $endTime
     * @param  string $timesTimezone  $admin->timezone
     * @return int                1=on_time, 2=late, 3=early
     * tested
     */
    public function checkOnTimeValue(Carbon $completedDate, string $startTime, string $endTime, string $timesTimezone)
    {
        if($this->checkIsOnTime($completedDate, $startTime, $endTime, $timesTimezone)){
            return 1; // onTime
        }elseif($this->checkIsLate($completedDate, $endTime, $timesTimezone)){
            return 2; // late
        }elseif($this->checkIsEarly($completedDate, $startTime, $timesTimezone)){
            return 3; //early
        }
        return 0; //unknown
    }

    /**
     * Check if the completed date is late.
     * Dates and times should be in the admin->timezone not UTC
     * @param  Carbon $completedDate   date the report was made
     * @param  string $startTime
     * @param  string $endTime
     * @param  string $timesTimezone  $admin->timezone
     * @return int                1=on_time, 2=late, 3=early
     */
    protected function prepareTime(Carbon $completedDate, string $time, string $timeTimezone)
    {
        $completedDateString = $completedDate->toDateString();
        return (new Carbon($completedDateString.' '.$time, $timeTimezone));
    }


}
