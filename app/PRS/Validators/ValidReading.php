<?php

namespace App\PRS\Validators;
use App\Report;
use App\Chemical;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ValidReading
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        $service_id = (isset($parameters[0])) ? $parameters[0] : '';
        $chemical_id = explode('.', $attribute)[1];

        // Check that the service seq_id sent through the parameters is correct
        try {
            $service = auth()->user()->selectedUser->company->services()->bySeqId($service_id);
        } catch (ModelNotFoundException $e) {
            return false;
        }

        // Check that the Chemical the reading is pointing to exists
        try {
            $chemical = $service->chemicals()->where('chemicals.id', $chemical_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        // Check that that chemical has a label for that reading
        return $chemical->globalChemical->labels->contains('value', $value);

    }

    public function message($message, $attribute)
    {
        return "The reading or the chemical is not valid.";
    }

}
