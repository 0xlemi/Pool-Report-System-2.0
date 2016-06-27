<?php

namespace App\PRS\Helpers;

use Carbon\Carbon;

class ReportHelpers
{

    public function checkOnTime($completed_date, $start_time, $end_time)
    {
        $carbon_time = new Carbon($completed_date);
        $completed_date_string = $carbon_time->toDateString();

        $carbon_start = new Carbon( $completed_date_string.' '.$start_time);
        $carbon_end = new Carbon( $completed_date_string.' '.$end_time);

        $on_time = 0;
        if($carbon_time->between($carbon_start, $carbon_end)){
            // onTime
            $on_time = 1;
        }elseif($carbon_time->gt($carbon_start)){
            // late
            $on_time = 2;
        }elseif($carbon_time->lt($carbon_end)){
            // early
            $on_time = 3;
        }
        return $on_time;
    }


}
