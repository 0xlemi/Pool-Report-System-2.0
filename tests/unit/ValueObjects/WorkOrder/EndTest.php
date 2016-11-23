<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

use App\PRS\ValueObjects\WorkOrder\End;

class EndTest extends TestCase
{

    /** @test */
    public function get_carbon_date_with_the_admin_timezone()
    {
        // Given
        $end = new End('2016-11-06 15:04:32', 'America/Vancouver');

        // When
        $carbon = $end->carbon();

        // Then
        $this->assertEquals($carbon, Carbon::parse("2016-11-06 07:04:32", "America/Vancouver"));

    }

    /** @test */
    public function get_end_date_as_a_string()
    {
        // Given
        $end = new End('2016-11-06 15:04:32', 'America/Vancouver');

        // When
        $string = (string) $end;

        // Then
        $this->assertEquals($string, "06 Nov 2016 07:04:32 AM");

    }

    /** @test */
    public function get_end_date_as_a_string_when_date_is_null()
    {
        // Given
        $end = new End(null, 'America/Vancouver');

        // When
        $string = (string) $end;

        // Then
        $this->assertEquals($string, "Not Finished");

    }

    /** @test */
    public function end_date_is_existent_means_work_order_is_finished()
    {
        // Given
        $endFinished = new End('2016-11-06 15:04:32', 'America/Vancouver');
        $endUnfinished = new End(null, 'America/Vancouver');

        // When
        $true = $endFinished->finished();
        $false = $endUnfinished->finished();

        // Then
        $this->assertTrue($true);
        $this->assertFalse($false);

    }

    /** @test */
    public function get_long_representation_string_of_the_date()
    {
        // Given
        $end = new End('2016-11-06 15:04:32', 'America/Vancouver');

        // When
        $string = $end->long();

        // Then
        $this->assertEquals($string, "Sunday 6th of November 2016 07:04:32 AM");

    }


}
