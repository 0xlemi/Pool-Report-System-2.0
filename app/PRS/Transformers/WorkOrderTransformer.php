<?php

namespace App\PRS\Transformers;

use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\PreviewTransformers\WorkPreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\SupervisorPreviewTransformer;

use App\PRS\Traits\ControllerTrait;
use App\Supervisor;
use App\Service;
use App\WorkOrder;
use Carbon\Carbon;

/**
 * Transformer for the service class
 */
class WorkOrderTransformer extends Transformer
{

    use ControllerTrait;

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

    public function transform(WorkOrder $workOrder)
    {
        $admin = $this->loggedUserAdministrator();

        $service = Service::findOrFail($workOrder->service_id);
        $supervisor = Supervisor::findOrFail($workOrder->supervisor_id);

        $attributes =  [
            'id' => $workOrder->seq_id,
            'title' => $workOrder->title,
            'description' => $workOrder->description,
            'start' => (new Carbon($workOrder->start, 'UTC'))->setTimezone($admin->timezone),
            'finished' => $workOrder->finished,
            'price' => $workOrder->price,
            'currency' => $workOrder->currency,
            'service'=> $this->serviceTransformer->transform($service),
            'supervisor'=> $this->supervisorTransformer->transform($supervisor),
            'works' => $this->workTransformer->transformCollection($workOrder->works()->get()),
            'photosBeforeWork' => $this->imageTransformer->transformCollection($workOrder->imagesBeforeWork()),
            'photosAfterWork' => $this->imageTransformer->transformCollection($workOrder->imagesAfterWork()),
        ];

        if(($workOrder->finished) && ($workOrder->end != null)){
            // add the end attribute to array
            $attributes = array_merge($attributes, [
                'end' => (new Carbon($workOrder->end, 'UTC'))->setTimezone($admin->timezone)
            ]);
        }

        return $attributes;
    }

}
