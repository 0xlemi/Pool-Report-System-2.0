<?php

namespace App\PRS\Transformers;

use App\Report;

use App\PRS\Transformers\ServiceTransformer;
use App\PRS\Transformers\TechnicianTransformer;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\TechnicianPreviewTransformer;
use Carbon\Carbon;


/**
 * Transformer for the report class
 */
class ReportTransformer extends Transformer
{

    private $servicePreviewTransformer;
    private $technicianPreviewTransformer;
    private $imageTransformer;

    public function __construct(
            ServicePreviewTransformer $servicePreviewTransformer,
            TechnicianPreviewTransformer $technicianPreviewTransformer,
            ImageTransformer $imageTransformer)
    {
        $this->servicePreviewTransformer = $servicePreviewTransformer;
        $this->technicianPreviewTransformer = $technicianPreviewTransformer;
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

        $admin = $report->admin();
        $completed_at = (new Carbon($report->completed, 'UTC'))
                            ->setTimezone($admin->timezone);

        return [
            'id' => $report->seq_id,
            'completed' => $completed_at,
            'on_time' => $report->on_time,
            'ph' => $report->ph,
            'chlorine' => $report->chlorine,
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
            'service' => $this->servicePreviewTransformer
                            ->transform($report->service()),
            'technician' => $this->technicianPreviewTransformer
                            ->transform($report->technician()),
        ];
    }


}
