<?php

namespace App\PRS\Validators;

use DB;
use App\GlobalMeasurement;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Service;
use App\PRS\Classes\Logged;
use Carbon\Carbon;

class ValidMeasurementValue
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        // Getting the Global Chemical
        if(array_key_exists($parameters[0], $value)){
            $globalMeasurement = Logged::company()->GlobalMeasurements()->bySeqId($value[$parameters[0]]);
        }else{
            return false;
        }
        return ($globalMeasurement->labels()->whereValue($value['value'])) ? true : false;
    }

    public function message($message, $attribute, $rule, $parameters)
    {
        return "{$attribute} error, measurment does not have a label with this value.";
    }

}
