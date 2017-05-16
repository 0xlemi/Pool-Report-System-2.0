<?php

namespace App\PRS\Validators;

use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Service;
use App\Report;
use Carbon\Carbon;

class CheckReportCanRemoveReadingFromServiceId
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        try {
            $service = Service::findOrFail($parameters[0]);
            $report = Report::findOrFail($parameters[1]);
            $company = $service->company;
            $globalMeasurement = $company->globalMeasurements()->bySeqId($value['measurement']);
            $measurement = $service->measurements()->where('global_measurement_id', $globalMeasurement->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }
        return $report->readings->contains('measurement_id', $measurement->id);
    }

    public function message($message, $attribute, $rule, $parameters)
    {
        return "The {$attribute}.measurement could not be removed. Because this report doesn't have a reading for that measurement.";
    }
}
