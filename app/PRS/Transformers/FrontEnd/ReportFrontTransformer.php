<?php

namespace App\PRS\Transformers\FrontEnd;

use App\Report;

use App\PRS\Transformers\ServiceTransformer;
use App\PRS\Transformers\TechnicianTransformer;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\TechnicianPreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\SupervisorPreviewTransformer;
use Carbon\Carbon;
use App\PRS\Transformers\Transformer;


/**
 * Transformer for the report class
 */
class ReportFrontTransformer extends Transformer
{

    private $servicePreviewTransformer;
    private $imageTransformer;

    public function __construct(
            ServicePreviewTransformer $servicePreviewTransformer,
            ImageTransformer $imageTransformer)
    {
        $this->servicePreviewTransformer = $servicePreviewTransformer;
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * Transform Report to api friendly array
     * @param  Report $report
     * @return array
     */
    public function transform(Report $report)
    {
        $supervisor = $report->supervisor();
        $technician = $report->technician;

        $supervisorPhoto = null;
        if($supervisor->imageExists()){
            $supervisorPhoto = $this->imageTransformer->transform($supervisor->image(1, false));
        }
        $technicianPhoto = null;
        if($technician->imageExists()){
            $technicianPhoto = $this->imageTransformer->transform($technician->image(1, false));
        }

        return [
            'id' => $report->seq_id,
            'completed' => $report->completed(),
            'on_time' => $report->on_time,
            'ph' => $report->ph,
            'chlorine' => $report->chlorine,
            'temperature' => $report->temperature,
            'turbidity' => $report->turbidity,
            'salt' => $report->salt,
            'photos' => $this->imageTransformer->transformCollection($report->images()->get()),
            'service' => $this->servicePreviewTransformer
                            ->transform($report->service),
            'supervisor' => [
                'id' => $supervisor->seq_id,
                'full_name' => $supervisor->name.' '.$supervisor->last_name,
                'email' => $supervisor->user->email,
                'cellphone' => $supervisor->cellphone,
                'address' => $supervisor->address,
                'language' => $supervisor->language,
                'photo' => $supervisorPhoto,
            ],
            'technician' => [
                'id' => $technician->seq_id,
                'full_name' => $technician->name.' '.$technician->last_name,
                'username' => $technician->user->email,
                'cellphone' => $technician->cellphone,
                'address' => $technician->address,
                'language' => $technician->language,
                'photo' => $technicianPhoto,
            ],
        ];
    }


}
