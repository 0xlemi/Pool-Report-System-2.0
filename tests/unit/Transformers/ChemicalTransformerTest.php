<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Chemical;
use App\PRS\Transformers\ChemicalTransformer;

class ChemicalTransformerTest extends TestCase
{

    /** @test */
    public function it_transforms_chemical()
    {
        // Given
        $mockChemical = Mockery::mock(Chemical::class);
        $mockChemical->shouldReceive('getAttribute')->with('id')->andReturn(3);
        $mockChemical->shouldReceive('getAttribute')->with('name')->andReturn('Salt');
        $mockChemical->shouldReceive('getAttribute')->with('amount')->andReturn('250.50');
        $mockChemical->shouldReceive('getAttribute')->with('units')->andReturn('PPM');

        // When
        $array = (new ChemicalTransformer)->transform($mockChemical);

        // Then
        $this->assertEquals($array, [
            'id' => 3,
            'name' => 'Salt',
            'amount' => '250.50',
            'units' => 'PPM',
        ]);


    }

}
