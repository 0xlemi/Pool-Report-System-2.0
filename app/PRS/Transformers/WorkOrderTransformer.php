<?php

namespace App\PRS\Transformers;

use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\PreviewTransformers\WorkPreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\SupervisorPreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\UserRoleCompanyPreviewTransformer;

use App\PRS\Traits\ControllerTrait;
use App\PRS\Classes\Logged;
use App\Supervisor;
use App\Service;
use App\WorkOrder;
use Carbon\Carbon;

/**
 * Transformer for the service class
 */
class WorkOrderTransformer extends Transformer
{

    private $workTransformer;
    private $serviceTransformer;
    private $urcPreviewTransformer;
    private $imageTransformer;

    public function __construct(
                        WorkPreviewTransformer $workTransformer,
                        ServicePreviewTransformer $serviceTransformer,
                        UserRoleCompanyPreviewTransformer $urcPreviewTransformer,
                        ImageTransformer $imageTransformer)
    {
        $this->workTransformer = $workTransformer;
        $this->serviceTransformer = $serviceTransformer;
        $this->urcPreviewTransformer = $urcPreviewTransformer;
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * Transform WorkOrder to api friendly array
     * @param  WorkOrder $workOrder
     * @return array
     */
    public function transform(WorkOrder $workOrder)
    {
        return collect([
            'id' => $workOrder->seq_id,
            'title' => $workOrder->title,
            'description' => $workOrder->description,
            'start' => $workOrder->start(),
            'finished' => $workOrder->end()->finished(),
            'price' => $workOrder->price,
            'currency' => $workOrder->currency,
            'service'=> $this->serviceTransformer->transform($workOrder->service),
            'person'=> $this->urcPreviewTransformer->transform($workOrder->userRoleCompany),
            'works' => $this->workTransformer->transformCollection($workOrder->works()->get()),
            'photosBeforeWork' => $this->imageTransformer->transformCollection($workOrder->imagesBeforeWork()),
            'photosAfterWork' => $this->imageTransformer->transformCollection($workOrder->imagesAfterWork()),
        ])->when($workOrder->end()->finished(), function($collection) use ($workOrder){
            return $collection->merge([
                'end' => Carbon::parse($workOrder->end)->setTimezone($workOrder->company->timezone)
            ]);
        });
    }

}
