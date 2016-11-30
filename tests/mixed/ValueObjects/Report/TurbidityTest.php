<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\ValueObjects\Report\Turbidity;

class TurbidityTest extends TestCase
{

    /** @test */
    public function get_turbidity_class_color()
    {
        // Given
        $tagMock = Mockery::mock('App\PRS\ValueObjects\Administrator\TagTurbidity');
        $turbidityPerfect = new Turbidity(1, $tagMock);
        $turbidityHigh = new Turbidity(3, $tagMock);
        $turbidityVeryHigh = new Turbidity(4, $tagMock);

        // When
        $perfect = $turbidityPerfect->class();
        $high = $turbidityHigh->class();
        $veryHigh = $turbidityVeryHigh->class();

        // Then
        $this->assertEquals($perfect, 'success');
        $this->assertEquals($high, 'warning');
        $this->assertEquals($veryHigh, 'danger');

    }

}
