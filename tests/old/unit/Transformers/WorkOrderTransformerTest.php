<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\Transformers\PreviewTransformers\WorkPreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\SupervisorPreviewTransformer;
use App\PRS\Transformers\WorkOrderTransformer;
use App\PRS\Transformers\ImageTransformer;
use App\Supervisor;
use App\Service;
use App\WorkOrder;

class WorkOrderTransformerTest extends TestCase
{

    protected $mockWorkPreviewTransformer;
    protected $mockServicePreviewTransformer;
    protected $mockSupervisorPreviewTransformer ;
    protected $mockImageTransformer ;
    protected $mockWorkOrder ;

    public function setUp()
    {
        parent::setUp();
        $this->mockWorkPreviewTransformer = Mockery::mock(WorkPreviewTransformer::class);
        $this->mockWorkPreviewTransformer->shouldReceive('transformCollection')->once()
                                    ->andReturn([
                                        'work1',
                                        'work2',
                                    ]);

        $this->mockServicePreviewTransformer = Mockery::mock(ServicePreviewTransformer::class);
        $this->mockServicePreviewTransformer->shouldReceive('transform')->once()->andReturn('ServicePreview');

        $this->mockSupervisorPreviewTransformer = Mockery::mock(SupervisorPreviewTransformer::class);
        $this->mockSupervisorPreviewTransformer->shouldReceive('transform')->once()->andReturn('SupervisorPreview');

        $this->mockImageTransformer = Mockery::mock(ImageTransformer::class);
        $this->mockImageTransformer->shouldReceive('transformCollection')->times(2)
                            ->andReturn([
                                'image1',
                                'image2',
                            ]);

        $this->mockWorkOrder = Mockery::mock(WorkOrder::class);
        $this->mockWorkOrder->shouldReceive('works->get')->once()->andReturn(null);
        $this->mockWorkOrder->shouldReceive('imagesBeforeWork')->once()->andReturn(null);
        $this->mockWorkOrder->shouldReceive('imagesAfterWork')->once()->andReturn(null);
        $this->mockWorkOrder->shouldReceive('start')->once()->andReturn('Start');
        $this->mockWorkOrder->shouldReceive('end')->andReturn('End');


        $this->mockWorkOrder->shouldReceive('getAttribute')->with('service')->andReturn(Mockery::mock(Service::class));
        $this->mockWorkOrder->shouldReceive('getAttribute')->with('supervisor')->andReturn(Mockery::mock(Supervisor::class));
        $this->mockWorkOrder->shouldReceive('getAttribute')->with('seq_id')->andReturn(5);
        $this->mockWorkOrder->shouldReceive('getAttribute')->with('title')->andReturn('Title');
        $this->mockWorkOrder->shouldReceive('getAttribute')->with('description')->andReturn('Description');
        $this->mockWorkOrder->shouldReceive('getAttribute')->with('price')->andReturn(234.12);
        $this->mockWorkOrder->shouldReceive('getAttribute')->with('currency')->andReturn('CAD');
        $this->mockWorkOrder->shouldReceive('getAttribute')->with('end')->andReturn('notNull');
    }

    /** @test */
    public function it_transforms_finished_work_order()
    {
        // Given
        $this->mockWorkOrder->shouldReceive('getAttribute')->with('finished')->andReturn(1);

        // When
        $array = (new WorkOrderTransformer($this->mockWorkPreviewTransformer,
                                            $this->mockServicePreviewTransformer,
                                            $this->mockSupervisorPreviewTransformer,
                                            $this->mockImageTransformer))
                                    ->transform($this->mockWorkOrder);

        // Then
        $this->assertEquals($array, [
            'id' => 5,
            'title' => 'Title',
            'description' => 'Description',
            'start' => 'Start',
            'finished' => 1,
            'price' => '234.12',
            'currency' => 'CAD',
            'service'=> 'ServicePreview',
            'supervisor'=> 'SupervisorPreview',
            'works' =>
                [
                    'work1',
                    'work2',
                ],
            'photosBeforeWork' =>
                [
                    'image1',
                    'image2',
                ],
            'photosAfterWork' =>
                [
                    'image1',
                    'image2',
                ],
            'end' => 'End',
        ]);

    }

    /** @test */
    public function it_transforms_unfinished_work_order()
    {
// Given
        $this->mockWorkOrder->shouldReceive('getAttribute')->with('finished')->andReturn(0);

        // When
        $array = (new WorkOrderTransformer($this->mockWorkPreviewTransformer,
                                            $this->mockServicePreviewTransformer,
                                            $this->mockSupervisorPreviewTransformer,
                                            $this->mockImageTransformer))
                                    ->transform($this->mockWorkOrder);

        // Then
        $this->assertEquals($array, [
            'id' => 5,
            'title' => 'Title',
            'description' => 'Description',
            'start' => 'Start',
            'finished' => 0,
            'price' => '234.12',
            'currency' => 'CAD',
            'service'=> 'ServicePreview',
            'supervisor'=> 'SupervisorPreview',
            'works' =>
                [
                    'work1',
                    'work2',
                ],
            'photosBeforeWork' =>
                [
                    'image1',
                    'image2',
                ],
            'photosAfterWork' =>
                [
                    'image1',
                    'image2',
                ],
        ]);

    }

}
