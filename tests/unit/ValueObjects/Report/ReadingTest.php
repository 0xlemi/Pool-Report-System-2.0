<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\ValueObjects\Report\Reading;

class ReadingTest extends TestCase
{

    /** @test */
    public function get_reading_to_string()
    {
        // Given
        $tagMock = Mockery::mock('App\PRS\ValueObjects\Administrator\Tag');
        $tagMock->shouldReceive('fromReading')
                ->once()
                ->andReturn('reading');
        $reading = new Reading(1, $tagMock);

        // When
        $string = (string) $reading;

        // Then
        $this->assertEquals($string, 'reading');

    }

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

    /** @test */
    public function get_styled_reading_html_span()
    {
        // Given
        $tagMock = Mockery::mock('App\PRS\ValueObjects\Administrator\Tag');
        $readingMock = Mockery::mock('App\PRS\ValueObjects\Report\Reading[class,toString]', [0, $tagMock]);
        $readingMock->shouldReceive('class')
                    ->once()
                    ->andReturn('class');
        $readingMock->shouldReceive('__toString')
                    ->once()
                    ->andReturn('text');

        // When
        $span = $readingMock->styled();

        // Then
        $this->assertEquals($span, '<span class="label label-class">text</span>');

    }

}
