<?php

namespace App\PRS\Transformers;

use App\Report;

use App\PRS\Transformers\ServiceTransformer;
use App\PRS\Transformers\TechnicianTransformer;


/**
 * Transformer for the report class
 */
class ReportTransformer extends Transformer
{

    protected $serviceTransformer;
    protected $technicianTransformer;

    public function __construct(
            ServiceTransformer $serviceTransformer,
            TechnicianTransformer $technicianTransformer)
    {
        $this->serviceTransformer = $serviceTransformer;
        $this->technicianTransformer = $technicianTransformer;
    }

    public function transform(Report $report)
    {
        return [
            'id' => $report->seq_id,
            'completed' => $report->completed,
            'on_time' => $report->on_time,
            'ph' => $report->ph,
            'clorine' => $report->clorine,
            'temperature' => $report->temperature,
            'turbidity' => $report->turbidity,
            'salt' => $report->salt,
            'latitude' => $report->latitude,
            'longitude' => $report->longitude,
            'altitude' => $report->altitude,
            'accuracy' => $report->accuracy,
            'service_id' => $report->service()->id,
            'technician_id' => $report->technician()->id,
        ];
    }


}
