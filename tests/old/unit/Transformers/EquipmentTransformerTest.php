<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Image;
use App\Equipment;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\EquipmentTransformer;

class EquipmentTransformerTest extends TestCase
{

    /** @test */
    public function it_transforms_equipment()
    {
        // Given
        $mockImageTransformer = Mockery::mock(ImageTransformer::class);
        $mockImageTransformer->shouldReceive('transformCollection')->once()
                            ->andReturn([
                                'image1',
                                'image2'
                            ]);
        $mockEquipment = Mockery::mock(Equipment::class);
        $mockEquipment->shouldReceive('images->get')->once()->andReturn(null);

        $mockEquipment->shouldReceive('getAttribute')->with('id')->andReturn(3);
        $mockEquipment->shouldReceive('getAttribute')->with('kind')->andReturn('Pump');
        $mockEquipment->shouldReceive('getAttribute')->with('type')->andReturn('Single-Speed');
        $mockEquipment->shouldReceive('getAttribute')->with('brand')->andReturn('Pentair');
        $mockEquipment->shouldReceive('getAttribute')->with('model')->andReturn('lem-213');
        $mockEquipment->shouldReceive('getAttribute')->with('capacity')->andReturn('4');
        $mockEquipment->shouldReceive('getAttribute')->with('units')->andReturn('HP');

        // When
        $array = (new EquipmentTransformer($mockImageTransformer))->transform($mockEquipment);

        // Then
        $this->assertEquals($array, [
            'id' => 3,
            'kind' => 'Pump',
            'type' => 'Single-Speed',
            'brand' => 'Pentair',
            'model' => 'lem-213',
            'capacity' => '4',
            'units' => 'HP',
            'photos' =>
            [
                'image1',
                'image2',
            ],
        ]);


    }

}
