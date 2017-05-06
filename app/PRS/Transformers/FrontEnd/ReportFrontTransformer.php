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
use App\PRS\Transformers\FrontEnd\ReadingFrontTransformer;


/**
 * Transformer for the report class
 */
class ReportFrontTransformer extends Transformer
{

    private $servicePreviewTransformer;
    private $imageTransformer;
    private $readingTransformer;

    public function __construct(
            ServicePreviewTransformer $servicePreviewTransformer,
            ReadingFrontTransformer $readingTransformer,
            ImageTransformer $imageTransformer)
    {
        $this->servicePreviewTransformer = $servicePreviewTransformer;
        $this->readingTransformer = $readingTransformer;
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
            'readings' => $this->readingTransformer->transformCollection($report->readings),
            'salt' => $report->salt,
            'photos' => $this->imageTransformer->transformCollection($report->images()->get()),
            'service' => $this->servicePreviewTransformer
                            ->transform($report->service),
            'urc' => [
                'id' => $urc->seq_id,
                'full_name' => $urc->user->fullName,
                'email' => $urc->user->email,
                'cellphone' => $urc->cellphone,
                'address' => $urc->address,
                'language' => $urc->user->language,
                'role' => $urc->role->text,
                'photo' => $urcPhoto,
            ],
        ];
    }


}
