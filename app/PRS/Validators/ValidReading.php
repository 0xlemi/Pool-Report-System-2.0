<?php

namespace App\PRS\Validators;
use App\Report;
use App\Measurement;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ValidReading
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        $service_id = (isset($parameters[0])) ? $parameters[0] : '';
        $measurement_id = explode('.', $attribute)[1];

        // Check that the service seq_id sent through the parameters is correct
        try {
            $service = auth()->user()->selectedUser->company->services()->bySeqId($service_id);
        } catch (ModelNotFoundException $e) {
            return false;
        }

        // Check that the Measurement the reading is pointing to exists
        try {
            $measurement = $service->measurements()->where('measurements.id', $measurement_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        // Check that that measurement has a label for that reading
        return $measurement->globalMeasurement->labels->contains('value', $value);

    }

    public function message($message, $attribute)
    {
        return "The reading or the measurement is not valid.";
    }

}
