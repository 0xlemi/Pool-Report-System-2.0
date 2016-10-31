<?php

namespace App\PRS\Validators;

use DB;
use Carbon\Carbon;

class TimeAfterDB
{

    public function validate($attribute, $value, $parameters)
    {
        $table = $parameters[0];
        $column = $parameters[1];
        $id = $parameters[2];

        $beforeDateRaw = DB::table($table)
            ->select($column)
            ->where('id', $id)
            ->first()->$column;

        $beforeDate = (new Carbon($beforeDateRaw, 'UTC'));
        $afterDate = (new Carbon($value))->setTimezone('UTC');

        return $beforeDate->lt($afterDate);
    }

    public function message($message, $attribute, $rule, $parameters)
    {
        $table = $parameters[0];
        $column = $parameters[1];
        $id = $parameters[2];

        $beforeDateRaw = DB::table($table)
            ->select($column)
            ->where('id', $id)
            ->first()->$column;

        return "The {$attribute} date should be after {$beforeDateRaw}";
    }

}
