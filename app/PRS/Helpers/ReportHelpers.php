<?php

namespace App\PRS\Helpers;

use Carbon\Carbon;
use App\PRS\Traits\ControllerTrait;

class ReportHelpers
{
    use ControllerTrait;

    // dates are NOT sent in UTC
    function format_date(string $date){
        $admin = $this->loggedUserAdministrator();
    	return (new Carbon($date, 'UTC'))
                ->setTimezone($admin->timezone)
                ->format('l jS \\of F Y h:i:s A');
    }

    // dates are NOT sent in UTC
    // start_time and end_time are not in UTC, thats why we dont convernt $completed_date
    public function checkOnTime(Carbon $completed_date, $start_time, $end_time)
    {
        $admin = $this->loggedUserAdministrator();

        $completed_date_string = $completed_date->toDateString();

        $carbon_start = new Carbon( $completed_date_string.' '.$start_time, $admin->timezone);
        $carbon_end = new Carbon( $completed_date_string.' '.$end_time, $admin->timezone);

        $on_time = 0;
        if($completed_date->between($carbon_start, $carbon_end)){
            // onTime
            $on_time = 1;
        }elseif($completed_date->gt($carbon_start)){
            // late
            $on_time = 2;
        }elseif($completed_date->lt($carbon_end)){
            // early
            $on_time = 3;
        }
        return $on_time;
    }

    function styleOnTime($on_time){
    	switch ($on_time) {
    		case '1':
    			return '<span class="label label-success">Done on Time</span>';
    			break;
    		case '2':
    			return '<span class="label label-danger">Done Late</span>';
    			break;
    		case '3':
    			return '<span class="label label-warning">Done Early</span>';
    			break;
    		default:
    			return '<span class="label label-default">Unknown</span>';
    			break;
    	}
    }

    function styleReadings($value, $is_turbidity = false){
    	if(!$is_turbidity){
    		switch ($value) {
    			case '1':
    				return '<span class="label label-info">Very Low</span>';
    				break;
    			case '2':
    				return '<span class="label label-primary">Low</span>';
    				break;
    			case '3':
    				return '<span class="label label-success">Perfect</span>';
    				break;
    			case '4':
    				return '<span class="label label-warning">High</span>';
    				break;
    			case '5':
    				return '<span class="label label-danger">Very High</span>';
    				break;
    			default:
    				return '<span class="label label-default">Unknown</span>';
    				break;
    		}
    	}
    	switch ($value) {
    		case '1':
    			return '<span class="label label-success">Perfect</span>';
    			break;
    		case '2':
    			return '<span class="label label-primary">Low</span>';
    			break;
    		case '3':
    			return '<span class="label label-warning">High</span>';
    			break;
    		case '4':
    			return '<span class="label label-danger">Very High</span>';
    			break;
    		default:
    			return '<span class="label label-default">Unknown</span>';
    			break;
    	}
    }


}
