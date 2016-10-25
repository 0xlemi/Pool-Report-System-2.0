<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\ValueObjects\Report\BaseReading;

class BaseReadingTest extends TestCase
{

    /** @test */
    public function get_base_reading_to_string()
    {
        // Given
        $tagMock = Mockery::mock('App\PRS\ValueObjects\Administrator\Tag');
        $tagMock->shouldReceive('fromReading')
                    ->once()
                    ->andReturn('reading');
        $readingMock = $this->getMockForAbstractClass(BaseReading::class, [0, $tagMock]);

        // When
        $string = (string) $readingMock;

        // Then
        $this->assertEquals($string, 'reading');

    }


    /** @test */
    public function get_styled_reading_html_span()
    {
        // Given
        $tagMock = Mockery::mock('App\PRS\ValueObjects\Administrator\Tag');
        $readingMock = $this->getMockForAbstractClass(BaseReading::class, [0, $tagMock], '', TRUE, TRUE, TRUE, ['class', '__toString']);
        $readingMock->expects($this->once())
                      ->method('class')
                      ->will($this->returnValue('class'));
      $readingMock->expects($this->once())
                      ->method('__toString')
                      ->will($this->returnValue('text'));

        // When
        $span = $readingMock->styled();

        // Then
        $this->assertEquals($span, '<span class="label label-class">text</span>');

    }

}
