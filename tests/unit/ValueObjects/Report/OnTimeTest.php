<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\ValueObjects\Report\OnTime;

class OnTimeTest extends TestCase
{

    /** @test */
    public function check_onTime_converts_to_string()
    {
        // Given
        $early = new OnTime('early');
        $onTime = new OnTime('onTime');
        $late = new OnTime('late');

        // When
        $stringEarly = (string) $early;
        $stringOnTime = (string) $onTime;
        $stringLate = (string) $late;

        // Then
        $this->assertEquals($stringEarly, 'Early');
        $this->assertEquals($stringOnTime, 'On Time');
        $this->assertEquals($stringLate, 'Late');

    }

        /** @test */
    public function check_onTime_converts_html_span_styled()
    {
        // Given
        $early = new OnTime('early');
        $onTime = new OnTime('onTime');
        $late = new OnTime('late');

        // When
        $stringEarly = $early->styled();
        $stringOnTime = $onTime->styled();
        $stringLate = $late->styled();

        // Then
        $this->assertEquals($stringEarly, '<span class="label label-warning">Early</span>');
        $this->assertEquals($stringOnTime, '<span class="label label-success">On Time</span>');
        $this->assertEquals($stringLate, '<span class="label label-danger">Late</span>');

    }

}
