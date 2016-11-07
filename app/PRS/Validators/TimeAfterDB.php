<?php

namespace App\PRS\Validators;

use DB;
use Carbon\Carbon;

class TimeAfterDB
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        $table = $parameters[0];
        $column = $parameters[1];
        $id = $parameters[2];
        $todayDate = Carbon::today()->toDateString();

        if($validator->hasAttribute($parameters[3])){
            $beforeTime = $validator->attributes()[$parameters[3]];
        }else{
            $beforeTime  = DB::table($table)
                ->select($column)
                ->where('service_id', $id)
                ->first()->$column;
        }
        $beforeDateTime =  "{$todayDate} {$beforeTime}";
        $afterDateTime =  "{$todayDate} {$value}";

        $beforeDate = new Carbon($beforeDateTime);
        $afterDate = new Carbon($afterDateTime);

        return $beforeDate->lt($afterDate);
    }

    public function message($message, $attribute, $rule, $parameters)
    {
        $table = $parameters[0];
        $column = $parameters[1];
        $id = $parameters[2];

        $beforeTime  = DB::table($table)
                ->select($column)
                ->where('service_id', $id)
                ->first()->$column;

        return "The {$attribute} date should be after start_time or DB start_time ({$beforeTime})";
    }

}
