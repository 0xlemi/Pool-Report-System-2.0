<?php

namespace App\PRS\Transformers;

use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\PreviewTransformers\WorkPreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\SupervisorPreviewTransformer;

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
    private $supervisorTransformer;
    private $imageTransformer;

    public function __construct(
                        WorkPreviewTransformer $workTransformer,
                        ServicePreviewTransformer $serviceTransformer,
                        SupervisorPreviewTransformer $supervisorTransformer,
                        ImageTransformer $imageTransformer)
    {
        $this->workTransformer = $workTransformer;
        $this->serviceTransformer = $serviceTransformer;
        $this->supervisorTransformer = $supervisorTransformer;
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * Transform WorkOrder to api friendly array
     * @param  WorkOrder $workOrder
     * @return array               
     */
    public function transform(WorkOrder $workOrder)
    {
        $attributes =  [
            'id' => $workOrder->seq_id,
            'title' => $workOrder->title,
            'description' => $workOrder->description,
            'start' => $workOrder->start(),
            'finished' => $workOrder->finished,
            'price' => $workOrder->price,
            'currency' => $workOrder->currency,
            'service'=> $this->serviceTransformer->transform($workOrder->service),
            'supervisor'=> $this->supervisorTransformer->transform($workOrder->supervisor),
            'works' => $this->workTransformer->transformCollection($workOrder->works()->get()),
            'photosBeforeWork' => $this->imageTransformer->transformCollection($workOrder->imagesBeforeWork()),
            'photosAfterWork' => $this->imageTransformer->transformCollection($workOrder->imagesAfterWork()),
        ];

        if(($workOrder->finished) && ($workOrder->end != null)){
            // add the end attribute to array
            $attributes = array_merge($attributes, [
                'end' => $workOrder->end()
            ]);
        }

        return $attributes;
    }

}
