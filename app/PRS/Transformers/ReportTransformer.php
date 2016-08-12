<?php

namespace App\PRS\Transformers;

use App\Report;

use App\PRS\Transformers\ServiceTransformer;
use App\PRS\Transformers\TechnicianTransformer;
use App\PRS\Transformers\ImageTransformer;


/**
 * Transformer for the report class
 */
class ReportTransformer extends Transformer
{

    private $serviceTransformer;
    private $technicianTransformer;
    private $imageTransformer;

    public function __construct(
            ServiceTransformer $serviceTransformer,
            TechnicianTransformer $technicianTransformer,
            ImageTransformer $imageTransformer)
    {
        $this->serviceTransformer = $serviceTransformer;
        $this->technicianTransformer = $technicianTransformer;
        $this->imageTransformer = $imageTransformer;
    }

    public function transform(Report $report)
    {
        $photo1 = 'no image';
        if($report->imageExists()){
            $photo1 = $this->imageTransformer->transform($report->image(1, false));
        }
        $photo2 = 'no image';
        if($report->imageExists()){
            $photo2 = $this->imageTransformer->transform($report->image(2, false));
        }
        $photo3 = 'no image';
        if($report->imageExists()){
            $photo3 = $this->imageTransformer->transform($report->image(3, false));
        }
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
            'photo1' => $photo1,
            'photo2' => $photo2,
            'photo3' => $photo3,
            'service_id' => $report->service()->id,
            'technician_id' => $report->technician()->id,
        ];
    }


}
