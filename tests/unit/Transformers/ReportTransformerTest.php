<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\TechnicianPreviewTransformer;
use App\PRS\Transformers\ReportTransformer;
use App\PRS\Transformers\ImageTransformer;
use App\Technician;
use App\Service;
use App\Report;

class ReportTransformerTest extends TestCase
{
    /** @test */
    public function it_transforms_report()
    {
        // Given
        $mockServicePreviewTransformer = Mockery::mock(ServicePreviewTransformer::class);
        $mockServicePreviewTransformer->shouldReceive('transform')->once()
                                        ->andReturn('ServicePreview');

        $mockTechnicianPreviewTransformer = Mockery::mock(TechnicianPreviewTransformer::class);
        $mockTechnicianPreviewTransformer->shouldReceive('transform')->once()
                                            ->andReturn('TechnicianPreview');

        $mockImageTransformer = Mockery::mock(ImageTransformer::class);
        $mockImageTransformer->shouldReceive('transformCollection')->once()
                                ->andReturn([
                                    'image1',
                                    'image2',
                                ]);

        $mockReport = Mockery::mock(Report::class);
        $mockReport->shouldReceive('completed')->once()->andReturn('completedCarbonDate');
        $mockReport->shouldReceive('images->get')->once()->andReturn(null);
        $mockReport->shouldReceive('service')->once()->andReturn(Mockery::mock(Service::class));
        $mockReport->shouldReceive('technician')->once()->andReturn(Mockery::mock(Technician::class));

        $mockReport->shouldReceive('getAttribute')->with('seq_id')->andReturn(5);
        $mockReport->shouldReceive('getAttribute')->with('on_time')->andReturn('onTime');
        $mockReport->shouldReceive('getAttribute')->with('ph')->andReturn(4);
        $mockReport->shouldReceive('getAttribute')->with('chlorine')->andReturn(2);
        $mockReport->shouldReceive('getAttribute')->with('temperature')->andReturn(3);
        $mockReport->shouldReceive('getAttribute')->with('turbidity')->andReturn(1);
        $mockReport->shouldReceive('getAttribute')->with('salt')->andReturn(5);
        $mockReport->shouldReceive('getAttribute')->with('latitude')->andReturn(123.123123);
        $mockReport->shouldReceive('getAttribute')->with('longitude')->andReturn(456.456456);
        $mockReport->shouldReceive('getAttribute')->with('accuracy')->andReturn(12.12);

        // When
        $array = (new ReportTransformer($mockServicePreviewTransformer,
                                        $mockTechnicianPreviewTransformer,
                                        $mockImageTransformer))
                                    ->transform($mockReport);

        // Then
        $this->assertEquals($array, [
            'id' => 5,
            'completed' => 'completedCarbonDate',
            'on_time' => 'onTime',
            'ph' => 4,
            'chlorine' => 2,
            'temperature' => 3,
            'turbidity' => 1,
            'salt' => 5,
            'location' =>
                [
                    'latitude' => 123.123123,
                    'longitude' => 456.456456,
                    'accuracy' => 12.12,
                ],
            'photos' =>
                [
                    'image1',
                    'image2',
                ],
            'service' => 'ServicePreview',
            'technician' => 'TechnicianPreview',
        ]);

    }


}
