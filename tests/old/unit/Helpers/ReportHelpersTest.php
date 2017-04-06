<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use App\PRS\Helpers\ReportHelpers;

class ReportHelpersTest extends TestCase
{

    /** @test */
    public function check_if_the_report_is_late()
    {
        // Given
        $timezone = 'UTC';
        $endTime = '16:10:30';
        $dateTimeCompletedAfter = (new Carbon('2016-10-03 16:10:31', $timezone));
        $dateTimeCompletedSame = (new Carbon('2016-10-03 16:10:30', $timezone));
        $dateTimeCompletedBefore = (new Carbon('2016-10-03 16:10:29', $timezone));

        // When
        $reportHelpers = new ReportHelpers;
        $after = $reportHelpers->checkIsLate($dateTimeCompletedAfter, $endTime, $timezone);
        $same = $reportHelpers->checkIsLate($dateTimeCompletedSame, $endTime, $timezone);
        $before = $reportHelpers->checkIsLate($dateTimeCompletedBefore, $endTime, $timezone);

        // Then
        $this->assertTrue($after);
        $this->assertFalse($same);
        $this->assertFalse($before);

    }

    /** @test */
    public function check_if_the_report_is_early()
    {
        // Given
        $timezone = 'UTC';
        $startTime = '14:10:30';
        $dateTimeCompletedAfter = (new Carbon('2016-10-03 14:10:31', $timezone));
        $dateTimeCompletedSame = (new Carbon('2016-10-03 14:10:30', $timezone));
        $dateTimeCompletedBefore = (new Carbon('2016-10-03 14:10:29', $timezone));

        // When
        $reportHelpers = new ReportHelpers;
        $after = $reportHelpers->checkIsEarly($dateTimeCompletedAfter, $startTime, $timezone);
        $same = $reportHelpers->checkIsEarly($dateTimeCompletedSame, $startTime, $timezone);
        $before = $reportHelpers->checkIsEarly($dateTimeCompletedBefore, $startTime, $timezone);

        // Then
        $this->assertFalse($after);
        $this->assertFalse($same);
        $this->assertTrue($before);

    }

    /** @test */
    public function check_if_the_report_is_onTime()
    {
        // Given
        $timezone = 'UTC';
        $endTime = '14:10:30';
        $startTime = '14:10:32';
        $dateTimeCompletedBetween = (new Carbon('2016-10-03 14:10:31', $timezone));
        $dateTimeCompletedSame1 = (new Carbon('2016-10-03 14:10:30', $timezone));
        $dateTimeCompletedSame2 = (new Carbon('2016-10-03 14:10:32', $timezone));
        $dateTimeCompletedAfter = (new Carbon('2016-10-03 14:10:33', $timezone));
        $dateTimeCompletedBefore = (new Carbon('2016-10-03 14:10:29', $timezone));

        // When
        $reportHelpers = new ReportHelpers;
        $between = $reportHelpers->checkIsOnTime($dateTimeCompletedBetween, $startTime, $endTime, $timezone);
        $same1 = $reportHelpers->checkIsOnTime($dateTimeCompletedSame1, $startTime, $endTime, $timezone);
        $same2 = $reportHelpers->checkIsOnTime($dateTimeCompletedSame2, $startTime, $endTime, $timezone);
        $after = $reportHelpers->checkIsOnTime($dateTimeCompletedAfter, $startTime, $endTime, $timezone);
        $before = $reportHelpers->checkIsOnTime($dateTimeCompletedBefore, $startTime, $endTime, $timezone);

        // Then
        $this->assertTrue($between);
        $this->assertTrue($same1);
        $this->assertTrue($same2);
        $this->assertFalse($after);
        $this->assertFalse($before);

    }


    /** @test */
    public function check_if_the_report_is_on_time_late_or_early_and_give_value()
    {
        // Given
        $timezone = 'UTC';
        $endTime = '16:10:30';
        $startTime = '14:10:30';
        $dateTimeCompletedLate = (new Carbon('2016-10-03 16:10:31', $timezone));
        $dateTimeCompletedEarly = (new Carbon('2016-10-03 14:10:29', $timezone));
        $dateTimeCompletedOnTime1 = (new Carbon('2016-10-03 15:10:20', $timezone));
        $dateTimeCompletedOnTime2 = (new Carbon('2016-10-03 14:10:30', $timezone));
        $dateTimeCompletedOnTime3 = (new Carbon('2016-10-03 16:10:30', $timezone));

        // When
        $reportHelpers = new ReportHelpers;
        $isLate = $reportHelpers->checkOnTimeValue($dateTimeCompletedLate, $startTime, $endTime, $timezone);
        $isEarly = $reportHelpers->checkOnTimeValue($dateTimeCompletedEarly, $startTime, $endTime, $timezone);
        $isOnTime1 = $reportHelpers->checkOnTimeValue($dateTimeCompletedOnTime1, $startTime, $endTime, $timezone);
        $isOnTime2 = $reportHelpers->checkOnTimeValue($dateTimeCompletedOnTime2, $startTime, $endTime, $timezone);
        $isOnTime3 = $reportHelpers->checkOnTimeValue($dateTimeCompletedOnTime3, $startTime, $endTime, $timezone);

        // Then
        $this->assertEquals($isOnTime1, 1);
        $this->assertEquals($isOnTime2, 1);
        $this->assertEquals($isOnTime3, 1);
        $this->assertEquals($isLate, 2);
        $this->assertEquals($isEarly, 3);

    }

}
