<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\ValueObjects\Report\Reading;

class ReadingTest extends TestCase
{

    /** @test */
    public function get_reading_class_color()
    {
        // Given
        $tagMock = Mockery::mock('App\PRS\ValueObjects\Administrator\Tag');
        $readingVeryLow = new Reading(1, $tagMock);
        $readingPerfect = new Reading(3, $tagMock);
        $readingVeryHigh = new Reading(5, $tagMock);

        // When
        $info = $readingVeryLow->class();
        $success = $readingPerfect->class();
        $danger = $readingVeryHigh->class();

        // Then
        $this->assertEquals($info, 'info');
        $this->assertEquals($success, 'success');
        $this->assertEquals($danger, 'danger');

    }

}
