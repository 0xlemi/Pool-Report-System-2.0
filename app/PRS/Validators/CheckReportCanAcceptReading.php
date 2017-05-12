<?php

namespace App\PRS\Validators;

use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Service;
use Carbon\Carbon;

class CheckReportCanAcceptReading
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        // Getting the Service
        if(array_key_exists($parameters[0], $validator->attributes())){
            $serviceId = $validator->attributes()[$parameters[0]];
        }else{
            return false;
        }
        try {
            $service = Service::findOrFail($serviceId);
        } catch (ModelNotFoundException $e) {
            return false;
        }
        return $service->measurements()->global()->get()->contains('seq_id', $value['measurement']);
    }

    public function message($message, $attribute, $rule, $parameters)
    {
        return "The {$attribute}.measurement could not be accepted. Because the service associated with this report don't have that measurment.";
    }
}
