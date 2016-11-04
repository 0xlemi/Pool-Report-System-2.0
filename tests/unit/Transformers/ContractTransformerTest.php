<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\ServiceContract;
use App\PRS\Transformers\ContractTransformer;

class ContractTransformerTest extends TestCase
{

    /** @test */
    public function it_transforms_contract()
    {
        // Given
        $mockServiceContract = Mockery::mock(ServiceContract::class);
        $mockServiceContract->shouldReceive('serviceDays->asArray')
                            ->once()
                            ->andReturn([
                                'monday' => true,
                                'tuesday' => false,
                                'wednesday' => true,
                                'thursday' => false,
                                'friday' => true,
                                'saturday' => false,
                                'sunday' => false,
                            ]);
        $mockServiceContract->shouldReceive('getAttribute')->with('active')->andReturn(1);
        $mockServiceContract->shouldReceive('getAttribute')->with('amount')->andReturn('78.23');
        $mockServiceContract->shouldReceive('getAttribute')->with('currency')->andReturn('CAD');
        $mockServiceContract->shouldReceive('getAttribute')->with('start_time')->andReturn('12:34');
        $mockServiceContract->shouldReceive('getAttribute')->with('end_time')->andReturn('4:39');
        $mockServiceContract->shouldReceive('getAttribute')->with('comments')->andReturn('Comments');

        // When
        $array = (new ContractTransformer)->transform($mockServiceContract);

        // Then
        $this->assertEquals($array, [
            'active' => true,
            'amount' => '78.23',
            'currency' => 'CAD',
            'start_time' => '12:34',
            'end_time' => '4:39',
            'service_days' => [
                'monday' => true,
                'tuesday' => false,
                'wednesday' => true,
                'thursday' => false,
                'friday' => true,
                'saturday' => false,
                'sunday' => false,
            ],
            'comments' => 'Comments',
        ]);


    }

}
