<?php

namespace App\PRS\Transformers;

use App\Report;

use App\PRS\Transformers\ServiceTransformer;
use App\PRS\Transformers\ReadingTransformer;
use App\PRS\Transformers\TechnicianTransformer;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\TechnicianPreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\SupervisorPreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\UserRoleCompanyPreviewTransformer;
use Carbon\Carbon;


/**
 * Transformer for the report class
 */
class ReportTransformer extends Transformer
{

    private $readingTransformer;
    private $servicePreviewTransformer;
    private $urcPreviewTrasformer;
    private $imageTransformer;

    public function __construct(
            ReadingTransformer $readingTransformer,
            ServicePreviewTransformer $servicePreviewTransformer,
            UserRoleCompanyPreviewTransformer $urcPreviewTrasformer,
            ImageTransformer $imageTransformer)
    {
        $this->readingTransformer = $readingTransformer;
        $this->servicePreviewTransformer = $servicePreviewTransformer;
        $this->urcPreviewTrasformer = $urcPreviewTrasformer;
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
            'readings' => $this->readingTransformer->transformCollection($report->readings),
            'location' =>
                [
                    'latitude' => $report->latitude,
                    'longitude' => $report->longitude,
                    'accuracy' => $report->accuracy,
                ],
            'service' => $this->servicePreviewTransformer
                                ->transform($report->service),
            'person' => $this->urcPreviewTrasformer
                                ->transform($report->userRoleCompany),
            'photos' => $this->imageTransformer->transformCollection($report->images()->get()),
        ];
    }


}
