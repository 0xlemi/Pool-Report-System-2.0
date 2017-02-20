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

    /**
     * Transform Report to api friendly array
     * @param  Report $report
     * @return array
     * tested
     */
    public function transform(Report $report)
    {
        return [
            'id' => $report->seq_id,
            'completed' => $report->completed(),
            'on_time' => $report->on_time,
            'ph' => $report->ph,
            'chlorine' => $report->chlorine,
            'temperature' => $report->temperature,
            'turbidity' => $report->turbidity,
            'salt' => $report->salt,
            'location' =>
                [
                    'latitude' => $report->latitude,
                    'longitude' => $report->longitude,
                    'accuracy' => $report->accuracy,
                ],
            'photos' => $this->imageTransformer->transformCollection($report->images()->get()),
            'service' => $this->servicePreviewTransformer
                            ->transform($report->service),
            'technician' => $this->technicianPreviewTransformer
                            ->transform($report->technician),
        ];
    }


}
