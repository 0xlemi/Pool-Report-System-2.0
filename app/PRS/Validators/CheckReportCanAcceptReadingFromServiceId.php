<?php

namespace App\PRS\Validators;

use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Service;
use Carbon\Carbon;

class CheckReportCanAcceptReadingFromServiceId
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        try {
            $service = Service::findOrFail($parameters[0]);
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
