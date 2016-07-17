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
