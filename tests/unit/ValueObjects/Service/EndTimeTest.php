<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use App\PRS\ValueObjects\Service\EndTime;


class EndTimeTest extends TestCase
{

    /** @test */
    public function get_end_time_as_a_string()
    {
        // Given
        $reportHelpersMock = Mockery::mock('App\PRS\Helpers\ReportHelpers');
        $endTime = new EndTime('15:30:30', 'UTC', $reportHelpersMock);

        // When
        $string = (string) $endTime;

        // Then
        $this->assertEquals($string, '3:30:30 PM');

    }

    /** @test */
    public function get_end_time_span_tag_colored_red_if_late()
    {
        // Given
        $reportHelpersMock = Mockery::mock('App\PRS\Helpers\ReportHelpers');
        $reportHelpersMock->shouldReceive('checkIsLate')
                            ->with(anything(), stringValue(), stringValue())
                            ->once()
                            ->andReturn(true);

        $endTimeMock = Mockery::mock('App\PRS\ValueObjects\Service\EndTime[toString]', array(
                                    stringValue(), stringValue(), $reportHelpersMock
                                ));
        $endTimeMock->shouldReceive('__toString')
                        ->once()
                        ->andReturn('3:30:30 PM');

        // When
        $string = $endTimeMock->colored();

        // Then
        $this->assertEquals($string, '<span class="label label-danger">3:30:30 PM</span>');

    }

    /** @test */
    public function get_end_time_span_tag_colored_green_if_still_on_time()
    {
        // Given
        $reportHelpersMock = Mockery::mock('App\PRS\Helpers\ReportHelpers');
        $reportHelpersMock->shouldReceive('checkIsLate')
                            ->with(anything(), stringValue(), stringValue())
                            ->once()
                            ->andReturn(false);

        $endTimeMock = Mockery::mock('App\PRS\ValueObjects\Service\EndTime[toString]', array(
                                    stringValue(), stringValue(), $reportHelpersMock
                                ));
        $endTimeMock->shouldReceive('__toString')
                        ->once()
                        ->andReturn('3:30:30 PM');

        // When
        $string = $endTimeMock->colored();

        // Then
        $this->assertEquals($string, '<span class="label label-success">3:30:30 PM</span>');

    }

}
