<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\ValueObjects\Service\StartTime;

class StartTimeTest extends TestCase
{
    /** @test */
    public function get_start_time_as_a_string()
    {
        // Given
        $startTime = new StartTime('15:30:30');

        // When
        $string = (string) $startTime;

        // Then
        $this->assertEquals($string, '3:30:30 PM');

    }

    /** @test */
    public function get_start_tim_as_timepicker_formated_string()
    {
        // Given
        $startTime = new StartTime('5:30:30');

        // When
        $string = $startTime->timePickerValue();

        // Then
        $this->assertEquals($string, '05:30');

    }

}
