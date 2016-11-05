<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\PreviewTransformers\TechnicianPreviewTransformer;
use App\PRS\Transformers\WorkTransformer;
use App\Technician;
use App\Work;

class WorkTransformerTest extends TestCase
{

    /** @test */
    public function it_transforms_work()
    {
        // Given
        $mockImageTransformer = Mockery::mock(ImageTransformer::class);
        $mockImageTransformer->shouldReceive('transformCollection')->once()
                            ->andReturn([
                                'image1',
                                'image2',
                            ]);

        $mockTechnicianPreviewTransformer = Mockery::mock(TechnicianPreviewTransformer::class);
        $mockTechnicianPreviewTransformer->shouldReceive('transform')->once()->andReturn('TechnicianPreview');

        $mockWorkOrder = Mockery::mock();
        $mockWorkOrder->currency = 'CAD';

        $mockWork = Mockery::mock(Work::class);
        $mockWork->shouldReceive('numImages')->once()->andReturn(2);
        $mockWork->shouldReceive('images->get')->once()->andReturn(null);
        $mockWork->shouldReceive('workOrder')->once()->andReturn($mockWorkOrder);
        $mockWork->shouldReceive('technician')->once()->andReturn(Mockery::mock(Technician::class));

        $mockWork->shouldReceive('getAttribute')->with('id')->andReturn(3);
        $mockWork->shouldReceive('getAttribute')->with('title')->andReturn('Title');
        $mockWork->shouldReceive('getAttribute')->with('description')->andReturn('Description');
        $mockWork->shouldReceive('getAttribute')->with('quantity')->andReturn('Quantity');
        $mockWork->shouldReceive('getAttribute')->with('units')->andReturn('Units');
        $mockWork->shouldReceive('getAttribute')->with('cost')->andReturn('Cost');

        // When
        $array = (new WorkTransformer($mockImageTransformer, $mockTechnicianPreviewTransformer))
                                    ->transform($mockWork);

        // Then
        $this->assertEquals($array, [
            'id' => 3,
            'title' => 'Title',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'units' => 'Units',
            'cost' => 'Cost',
            'currency' => 'CAD',
            'technician' => 'TechnicianPreview',
            'photos' =>
                [
                    'image1',
                    'image2',
                ],
        ]);

    }

}
