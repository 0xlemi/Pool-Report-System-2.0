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
        $urc = $report->userRoleCompany;

        $urcPhoto = null;
        if($urc->imageExists()){
            $urcPhoto = $this->imageTransformer->transform($urc->image(1, false));
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
            'urc' => [
                'id' => $urc->seq_id,
                'full_name' => $urc->name.' '.$urc->last_name,
                'username' => $urc->user->email,
                'cellphone' => $urc->cellphone,
                'address' => $urc->address,
                'language' => $urc->language,
                'photo' => $urcPhoto,
            ],
        ];
    }


}
