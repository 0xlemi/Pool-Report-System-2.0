<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\PRS\ValueObjects\Administrator\Tag;

class TagTest extends TestCase
{

    use TesterTrait;


    /** @test */
    public function get_tag_as_array()
    {
        // Given
        $tag = new Tag('first', 'second', 'third',
                        'fourth', 'fifth');

        // When
        $array = $tag->asArray();

        // Then
        $this->assertSameArray($array, [
            1 => 'first',
            2 => 'second',
            3 => 'third',
            4 => 'fourth',
            5 => 'fifth',
        ]);

    }

    /** @test */
    public function get_tag_from_number_of_the_reading()
    {
        // Given
        $mock = Mockery::mock('App\PRS\ValueObjects\Administrator\Tag[asArray]', ['','','','','']);
        $mock->shouldReceive('asArray')
                ->times(3)
                ->andReturn([
                        1 => 'first',
                        2 => 'second',
                        3 => 'third',
                        4 => 'fourth',
                        5 => 'fifth',
                    ]);

        // When
        $second = $mock->fromReading(2);
        $third = $mock->fromReading(3);
        $fifth = $mock->fromReading(5);

        // Then
        $this->assertEquals($second, 'second');
        $this->assertEquals($third, 'third');
        $this->assertEquals($fifth, 'fifth');

    }

}
